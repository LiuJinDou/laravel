<?php
namespace App\Models\Admin;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Book extends Model {

    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'book';
    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * book list
     * @param $limit
     * @param $page
     * @param $request
     * @return mixed
     */
    public function list($limit,$page,$request){
        $name = $request->input('name');
        $category_id = $request->input('category_id');
        if ($category_id) {
            $rtn = app('Book')->where('name','like',"%$name%")->where('category_id','=',$category_id)->orderBy('status', 'asc')->orderBy('share_status', 'ACS')->paginate($limit);
        } else {
            $rtn = app('Book')->where('name','like',"%$name%")->orderBy('status', 'asc')->orderBy('share_status', 'ACS')->paginate($limit);
        }

        $results = $rtn->toArray();
        $category = app('book_category')::all(['id','name'])->toArray();
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
     * editor book
     * @param $request
     * @return bool
     * @throws \Exception
     */
    public function editor($request){
        $id = $request->input('id');
        $name = $request->input('name');
        $category_id = $request->input('category_id');
        $image = $request->input('image');
        $introduction = $request->input('introduction');
        $author = $request->input('author');
        $author_desc = $request->input('author_desc');
        $tags = $request->input('tags');
        $content = $request->input('content');

        try{
            if ($id > 0) {
                $book =  self::find($id);
                $book->update_at = time();
                $book->update_uid = app('Admin')->getAdminId();
            } else {
                $book =  app('Book');
                $book->create_at = time();
                $book->create_uid = app('Admin')->getAdminId();
            }
            $book->name         = $name;
            $book->category_id  = $category_id;
            $book->image        = $image;
            $book->author       = $author;
            $book->author_desc  = $author_desc;
            $book->tags         = $tags;
            $book->introduction = $introduction;
            $book->content      = $content;
            $book->save();
            $article_id = $book->article_id;

            if ($article_id && $id>0) {
                $article = app('Article')->find($article_id);
                $article->title        = $name;
                $article->image        = $image;
                $article->introduction = $introduction;
                $article->content      = $content;
                $article->tags         = $tags;
                $article->update_at    = time();
                $article->update_uid   = app('Admin')->getAdminId();
                $article->save();
            }

        }catch (\Exception $exception){
            throw  new \Exception($exception->getMessage(),$exception->getCode());
        }
        return true;
    }

    /**
     * share
     * @param $id
     * @throws \Exception
     */
    public function share($id){

        $info = app('Book')->find($id);
        if (!$info->status) {
            throw new  \Exception('Cant`t be share');
        }
        try{
            $article = app('Article');
            $article->category_id  = 4;
            $article->title        = $info->name;
            $article->image        = $info->image;
            $article->introduction = $info->introduction;
            $article->content      = $info->content;
            $article->tags         = $info->tags;
            $article->status       = 1;
            $article->create_at    = time();
            $article->create_uid   = app('Admin')->getAdminId();
            $article->save();
            $article_id = $article->id;
            $data['data'] = app('Book')->where(['id'=>$id])->update(['share_status'=>1,'article_id'=>$article_id]);
        }catch (\Exception $exception){
            throw  new \Exception($exception->getMessage(),$exception->getCode());
        }

    }

    /**
     * book name
     * @param $id
     * @return mixed
     */
    public function bookName($id){
        if (app('book_category')->where('parent_id','=',$id)->exists()) {
            $category_ids = app('book_category')->where('parent_id','=',$id)->get(['parent_tree'])->toArray();
            $category_ids = array_map(function ($item){
                return explode(',',$item['parent_tree']);
            },$category_ids);
            $category_ids = array_unique(array_reduce($category_ids, 'array_merge', array()));
        } else {
            $category_ids = [$id];
        }

        return app('Book')::whereIn('category_id',$category_ids)->get(['id','name'])->toArray();
    }

    /**
     * category list
     * @return array
     */
    public function categoryList(){
        $category = app('book_category')::all(['id','name','level','parent_tree','parent_id'])->toArray();
        $category = array_map(function ($item){
            $item['title'] = $item['name'];
            return $item;
        },$category);

        $category = app('Common')->createTree($category);

        return $category;
    }

    /**
     * category editor
     * @param $request
     * @return mixed
     * @throws \Exception
     */
    public function categoryEditor($request){
        $id = $request->input('id',0);
        $name = $request->input('name');
        $parent_id = $request->input('p_id',0);
        if ($id > 0) {
            $category =  app('book_category')->find($id);
            $category->update_at = time();
            $category->update_uid = app('Admin')->getAdminId();
        } else {
            $category =  app('book_category');
            $category->update_at = time();
            $category->update_uid = app('Admin')->getAdminId();
        }
        $category->name = $name;
        try{
            if ($parent_id > 0) {
                $parent_info =  app('book_category')->find($parent_id);
                $category->parent_id = $parent_id;
                $category->level = $parent_info->level;
                $category->save();
                $child_id = $category->id;
                $child_category = $category->find($child_id);
                $child_category->parent_tree = $parent_id.','.$child_id;
                return $child_category->save();
            } else {
                return $category->save();
            }
        }catch (\Exception $exception){
            throw new \Exception('Editor error',2001);
        }

    }

    /**
     * category del
     * @param $request
     * @return mixed
     * @throws \Exception
     */
    public function categoryDel($request){
        $id = $request->input('id');
        if (empty($id)) {
            throw new \Exception('Parameter error',2001);
        }
        $category = app('book_category')->where('parent_id','=',$id)->exists();

        if ($category) {
            throw new \Exception('Privilege error',2001);
        }

        return app('book_category')::destory($id);

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