<?php
namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;
use  Swoole\WebSocket\Server;

class Webim extends Model{

    public $server;

    public $table;

    protected $config;

    public function __init()
    {
        $this->createTable();
        $this->config =[
            'ip'    =>'0.0.0.0',
            'port'  => '9501',

            'avatar' => [
                './images/avatar/1.jpg',
                './images/avatar/2.jpg',
                './images/avatar/3.jpg',
                './images/avatar/4.jpg',
                './images/avatar/5.jpg',
                './images/avatar/6.jpg'
            ],
            'name' => [
                '科比',
                '库里',
                'KD',
                'KG',
                '乔丹',
                '邓肯',
                '格林',
                '汤普森',
                '伊戈达拉',
                '麦迪',
                '艾弗森',
                '卡哇伊',
                '保罗'
            ]
        ];
    }

    /**
     * 启动
     */
    public function run()
    {
        $this->__init();

        $this->server = new Server($this->config['ip'], $this->config['port']);

        $this->server->on('open', [$this, 'open']);
        $this->server->on('message', [$this, 'message']);
        $this->server->on('close', [$this, 'close']);

        $this->server->start();
    }

    /**
     * @param Server $server
     * @param $request
     */
    public function open(Server $server, $request)
    {
        $user = [
            'fd' => $request->fd,
            'name' => $this->config['name'][array_rand($this->config['name'])].$request->fd,
            'avatar' => $this->config['avatar'][array_rand($this->config['avatar'])]
        ];
        $this->table->set($request->fd, $user);

        $server->push($request->fd, json_encode(
                array_merge(['user' => $user], ['all' => $this->allUser()], ['type' => 'openSuccess'])
            )
        );
        $this->pushMessage($server, "欢迎".$user['name']."进入聊天室", 'open', $request->fd);
    }

    private function allUser()
    {
        $users = [];
        foreach ($this->table as $row) {
            $users[] = $row;
        }
        return $users;
    }

    /**
     * @param Server $server
     * @param $frame
     */
    public function message(Server $server, $frame)
    {
        $this->pushMessage($server, $frame->data, 'message', $frame->fd);
    }


    /**
     * @param Server $server
     * @param $fd
     */
    public function close(Server $server, $fd)
    {
        $user = $this->table->get($fd);
        $this->pushMessage($server, $user['name']."离开聊天室", 'close', $fd);
        $this->table->del($fd);
    }

    /**
     * 遍历发送消息
     *
     * @param Server $server
     * @param $message
     * @param $messageType
     * @param int $skip
     */
    private function pushMessage(Server $server, $message, $messageType, $frameFd)
    {
        $message = htmlspecialchars($message);
        $datetime = date('Y-m-d H:i:s', time());
        $user = $this->table->get($frameFd);
        foreach ($this->table as $row) {
            if ($frameFd == $row['fd']) {
                continue;
            }
            $server->push($row['fd'], json_encode([
                    'type' => $messageType,
                    'message' => $message,
                    'datetime' => $datetime,
                    'user' => $user
                ])
            );
        }
    }

    /**
     * 创建内存表
     */
    private function createTable()
    {
        $this->table = new \swoole_table(1024);
        $this->table->column('fd', \swoole_table::TYPE_INT);
        $this->table->column('name', \swoole_table::TYPE_STRING, 255);
        $this->table->column('avatar', \swoole_table::TYPE_STRING, 255);
        $this->table->create();
    }
}