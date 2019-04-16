<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;
use App\Model\Permissions;
use App\Tools\ToolsAdmin;
class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //判断用户是否登录
        $session = $request->session();
        // if(!$session->has('user')){  //未登录
        //     return redirect('/admin/login')->send(); //跳转并发送
        // }
        // 完成视图共享
        View::share('username',$session->get('user.username'));
        View::share('image_url',$session->get('user.image_url'));
        $user = $session->get('user');
        View::share('menus',Permissions::getMenus($user));
        return $next($request);
    }
}
