<?php
namespace App\Models\Admin;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Article extends Model {

    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'article';
    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * 文章列表
     * @param $limit
     * @param $page
     * @param $request
     * @return mixed
     */
    public function list($limit,$page,$request){
        $title = $request->input('title');
        $category_id = $request->input('category_id');
        if ($category_id) {
            $results = app('Article')->where('title','like',"%$title%")->orderBy('status', 'asc')->orderBy('update_at', 'ACS')->where('category_id','=',$category_id)->paginate($limit)->toArray();;
        } else {
            $results = app('Article')->where('title','like',"%$title%")->orderBy('status', 'asc')->orderBy('update_at', 'ACS')->paginate($limit)->toArray();;
        }

        $category = app('article_category')::all(['id','name'])->toArray();
        $category = array_column($category,'name','id');

        $rst['data'] = array_map(function ($item)  use($category){
            $item['category_name'] = isset($category[$item['category_id']]) ? $category[$item['category_id']] : '';
            return $item;
        },$results['data']);
        $rst['count'] = $results['total'];
        $rst['last_page_url'] = $results['last_page_url'];
        $rst['next_page_url'] = $results['next_page_url'];
        $rst['prev_page_url'] = $results['prev_page_url'];
        $rst['first_page_url'] = $results['first_page_url'];
        return $rst;
    }

    /**
     * get the current article detail
     * @param $id
     * @param array $field
     * @return mixed
     */
    public function info($id,$field = ['*']){
        $doesntExist = app('Article')->where('id','=',$id)->where('status','=',1)->doesntExist();
        if ($doesntExist) {
            return false;
        }
        $rtn = app('Article')->where('id','=',$id)->first($field)->toArray();
        self::increase($id);
        $rtn['create_at'] = date('Y-m-d H:i:s',$rtn['create_at']);
        $rtn['tags'] = array_filter(explode('-',$rtn['tags']));
        return $rtn;
    }

    /**
     * increase value
     * @param $id
     * @return mixed
     */
    public function increase($id,$field='browse',$value=1){
        return app('Article')->where('id',$id)->increment($field,$value);
    }

    /**
     * decrease value
     * @param $id
     * @param string $field
     * @param $value
     * @return mixed
     */
    public function decrease($id,$field = 'browse',$value){
        return app('Article')->where('id',$id)->decrement($field,$value);

    }
    /**
     * get the prev article detail
     * @param $id
     * @return mixed
     */
    public function getPrevArticleId($id){
        $prevId =  app('Article')::where('id', '<', $id)->select('id','title')->max('id');
        if ($prevId == NULL) {
            $prev =  app('Article')::inRandomOrder()->where('id','!=',$id)->first(['id','title'])->toArray();

        } else {
            $prev = app('Article')->where('id','=',$prevId)->first(['id','title'])->toArray();
        }

        return $prev;
    }

    /**
     * get the next article detail
     * @param $id
     * @return mixed
     */
    public function getNextArticleId($id){
        $nextId =  app('Article')::where('id', '>', $id)->select('id','title')->min('id');
        if ($nextId == NULL) {
            $next =  app('Article')::inRandomOrder()->where('id','!=',$id)->first(['id','title'])->toArray();

        } else {
            $next = app('Article')->where('id','=',$nextId)->first(['id','title'])->toArray();
        }

        return $next;
    }

    /**
     * 编辑文章
     * @param $request
     * @return mixed
     */
    public function editor($request){
        $id = $request->input('id');
        $title = $request->input('title');
        $category_id = $request->input('category_id');
        $image = $request->input('image');
        $introduction = $request->input('introduction');
        $tags = $request->input('tags');
        $content = $request->input('content');
        if ($id > 0) {
            $article =  self::find($id);
            $article->update_at = time();
            $article->update_uid = app('Admin')->getAdminId();
        } else {
            $article =  app('Article');
            $article->create_at = time();
            $article->create_uid = app('Admin')->getAdminId();
        }
        $article->title = $title;
        $article->category_id = $category_id;
        $article->image = $image;
        $article->introduction = $introduction;
        $article->tags = $tags;
        $article->content = $content;
        return $article->save();
    }

    /**
     * Search article
     * @param $keyboard
     * @return false|string
     */
    public function searchArticle($keyboard){
        $doesntExist = app('Article')->where('title','like',"%$keyboard%")->doesntExist();
        if ($doesntExist) {
            return [];
        }
        $search =  app('Article')->where('title','like',"%$keyboard%")->paginate()->toArray()['data'];
        $search = $this->handleTime($search,2);
        return $search;
    }

    /**
     * article name
     * @param $id
     * @return mixed
     */
    public function articleName($id){

        if (app('article_category')->where('parent_id','=',$id)->exists()) {
            $category_ids = app('article_category')->where('parent_id','=',$id)->get(['parent_tree'])->toArray();
            $category_ids = array_map(function ($item){
                return explode(',',$item['parent_tree']);
            },$category_ids);
            $category_ids = array_unique(array_reduce($category_ids, 'array_merge', array()));
        } else {
            $category_ids = [$id];
        }

        return app('Article')::whereIn('category_id',$category_ids)->get(['id','title'])->toArray();
    }

    /**
     * Editor category
     * @param $request
     * @return mixed
     */
    public function categoryEditor($request){
        $id = $request->input('id',0);
        $name = $request->input('name');
        $parent_id = $request->input('p_id',0);
        if ($id > 0) {
            $category =  app('article_category')->find($id);
            $category->update_at = time();
            $category->update_uid = app('Admin')->getAdminId();
        } else {
            $category =  app('article_category');
            $category->update_at = time();
            $category->update_uid = app('Admin')->getAdminId();
        }
        $category->name = $name;

        if ($parent_id > 0) {
            $category->parent_id = $parent_id;
            $category->level = 2;
            $category->save();
            $child_id = $category->id;
            $child_category = $category->find($child_id);
            $child_category->parent_tree = $parent_id.','.$child_id;
            return $child_category->save();
        } else {
            return $category->save();
        }

    }

    /**
     * use closure也就是匿名函数（减少foreach循环的代码，减少函数参数，解除递归函数，关于延迟绑定）
     * categoryList
     * @return array
     */
    public function categoryList(){
        $category = app('article_category')::all(['id','name','level','parent_tree','parent_id'])->toArray();

        $category = array_map(function ($item){
            $item['title'] = $item['name'];
            return $item;
        },$category);
        $first_category = array_filter($category,function ($item){
           return intval($item['level']) == 1;
        });
        $second_category = array_filter($category,function ($item){
            return intval($item['level']) == 2;
        });
        $first_category = array_map(function ($item) use ($second_category) {
            $item['children'] = array_values($this->combine($item['id'], $second_category));
            return $item;
        }, $first_category);

        return $first_category;
    }

    /**
     * handle category
     * @param $id
     * @param $array
     * @return array
     */
    private function combine($id, $array)
    {
        return array_filter($array, function ($item) use ($id) {
            return $item['parent_id'] == $id;
        });
    }
    public function categoryDel($id){
        $child_exit =  app('article_category')->where('parent_id','=',$id)->exists();

        if ($child_exit) {
            throw  new  \Exception('Can not be deleted',1001);
        }
        return app('article_category')->destroy($id);
    }
    public function message($page,$limit){
        $rtn = app('Message')->paginate($limit)->toArray();
        $article = app('Article')->all(['id','title'])->toArray();
        $article = array_column($article,'title','id');

        $rst['data'] = isset($rtn['data']) ? $rtn['data'] : [];
        $rst['count'] = isset($rtn['total']) ? $rtn['total'] : 0;
        $rst['data'] = array_map(function ($item) use ($article){
            $item['name'] = htmlentities($item['name']);
            $item['content'] = htmlentities($item['content']);
            $item['title'] = isset($article[$item['article_id']]) ? $article[$item['article_id']] : '';
            return $item;
        },$rtn['data']);
        return $rst;
    }

    /**
     * Handle Time
     * @param $data
     * @param int $split_type
     * @return false|string
     */
    public function handleTime($data,$split_type=1){
        if (is_array($data)) {
            foreach ($data as &$item) {
                switch ($split_type) {
                    case 1:
                        $item['create_at'] = date('Y-m-d H:i:s',$item['create_at']);
                        break;
                    case 2:
                        $item['create_at'] = date('Y-m-d',$item['create_at']);
                        break;
                    case 3:
                        $item['create_at'] = date('H:i:s',$item['create_at']);
                        break;
                    default :
                        $item['create_at'] = date('Y-m-d H:i:s',$item['create_at']);
                        break;
                }
            }
        } else {
            switch ($split_type) {
                case 1:
                    $data = date('Y-m-d H:i:s',$data);
                    break;
                case 2:
                    $data = date('Y-m-d',$data);
                    break;
                case 3:
                    $data = date('H:i:s',$data);
                    break;
                default :
                    $data = date('Y-m-d H:i:s',$data);
                    break;
            }
        }

        return $data;
    }
}