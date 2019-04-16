<?php
namespace App\Http\Controllers\Study;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Study\BsBonus;
use App\Study\BsBonusRecord;
use Log;
class BonusController extends Controller
{
    //
    public function index()
    {
    }
    /**
     * @抢红包的业务逻辑
     * 1、判断红包id和user_id是否传递
     * 2、判断一下红包是否存在
     * 3、判断红包是否已经抢完
     * 4、是否是最后一个人抢红包
     */
    public function getBonus(Request $request)
    {
    	//获取所有的参数
    	$params = $request->all();
    	$return = [
    		'code' => 2000,
    		'msg'  => '成功'
    	];
    	//用户id
    	if(!isset($params['user_id']) || empty($params['user_id'])){
    		$return = [
    			'code' => 4001,
    			'msg'  => "用户未登录"
    		];
    		return json_encode($return);
    	}
    	//红包id
    	if(!isset($params['bonus_id']) || empty($params['bonus_id'])){
    		$return = [
    			'code' => 4002,
    			'msg'  => "请选择指定的红包"
    		];
    		return json_encode($return);
    	}
    	//2 检测红包是否存在
    	$bonus = BsBonus::getBonusInfo($params['bonus_id']);
    	if(empty($bonus)){
    		$return = [
    			'code' => 4003,
    			'msg'  => "红包不存在"
    		];
    		return json_encode($return);
    	}
    	$record = BsBonusRecord::getRecordById($params['user_id'], $params['bonus_id']);
    	if($record){
    		$return = [
    			'code' => 4005,
    			'msg'  => "你已经抢过该红包了"
    		];
    		return json_encode($return);
    	}
    	//3、红包是否被抢光
    	if($bonus->left_amount <=0 || $bonus->left_nums <=0)
    	{
    		$return = [
    			'code' => 4004,
    			'msg'  => "红包已经被抢光了"
    		];
    		return json_encode($return);
    	}
    	//4、是否最后一个红包
    	if($bonus->left_nums == 1){
    		Log::info('最后一个红包，抢到的人id'.$params['user_id']);
    		//用户抢到的金额
    		$getMoney = $bonus->left_amount;
    		//插入用户抢到的一条bonus_record记录
    		$data = [
    			'user_id' => $params['user_id'],
    			'bonus_id' => $params['bonus_id'],
    			'money'    => $getMoney,
    			'flag'     =>1
    		];
    		BsBonusRecord::createRecord($data);
    		//更新红包表的数据
    		$data1 = [
    			'left_amount' => 0,
    			'left_nums'  => 0
    		];
    		BsBonus::updateBonusInfo($data1, $params['bonus_id']);
    		//评选出运气王
    		//1、降序排列红包抢的记录
    		$res = BsBonusRecord::getMaxBonus($params['bonus_id']);
    		//2、更新抢红包的记录
    		BsBonusRecord::updateBonusRecord(['flag'=>2], $res->id);
    	}else{
    		$min = 0.01;//最小金额
    		$max = $bonus->left_amount - ($bonus->left_nums -1)*0.01; //最大金额
    		$getMoney = rand($min*100, $max*100)/100; //获取金额随机值
    		//插入用户抢到的一条bonus_record记录
    		$data = [
    			'user_id' => $params['user_id'],
    			'bonus_id' => $params['bonus_id'],
    			'money'    => $getMoney,
    			'flag'     =>1
    		];
    		BsBonusRecord::createRecord($data);
    		//更新红包的金额
    		$data1 = [
    			'left_amount' => $bonus->left_amount - $getMoney,
    			'left_nums'  => $bonus->left_nums - 1
    		];
    		BsBonus::updateBonusInfo($data1, $params['bonus_id']);
    	}
       return json_encode($return);
    }

}

// ==========================================================
<?php
namespace App\Study;
use Illuminate\Database\Eloquent\Model;
class Guess extends Model
{
    //
    protected $table = "study_guess";
    public $timestamps = false;
    public function add($data)
    {
        return self::insert($data);
    }
    public function getList()
    {
        return self::get()->toArray();
    }
    public function getInfo($id)
    {
        return self::where('id',$id)->first();
    }
}

<?php
namespace App\Study;
use Illuminate\Database\Eloquent\Model;
class Guess extends Model
{
    //
    protected $table = "study_guess";
    public $timestamps = false;
    public function add($data)
    {
        return self::insert($data);
    }
    public function getList()
    {
        return self::get()->toArray();
    }
    public function getInfo($id)
    {
        return self::where('id',$id)->first();
    }
}

<?php
namespace App\Http\Controllers\Study;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Study\Guess;
use Illuminate\Support\Facades\DB;
class GuessController extends Controller
{
    //足球精彩的添加页面
    public function add()
    {
        return view('study.guess.add');
    }
    public function doAdd(Request $request)
    {
        $params = $request->all();
        $guess = new Guess();
        $data = [
            'team_a' => $params['team_a'],
            'team_b' => $params['team_b'],
            'end_at' => $params['end_at']
        ];
        $guess->add($data);
        return redirect('/study/guess/list?user_id=1');
    }
    //列表页面
    public function list(Request $request)
    {
        $params = $request->all();
        $guess = new Guess();
        $assign['list'] = $guess->getList();
        $assign['user_id'] = isset($params['user_id']) ?? 1;
        return view('study.guess.list',$assign);
    }
    public function guess(Request $request)
    {
        $params = $request->all();
        $guess = new Guess();
        $assign['info'] = $guess->getInfo($params['id']);
        $assign['user_id'] = isset($params['user_id']) ?? 1;
        return view('study.guess.guess', $assign);
    }
    //执行添加页面
    public function doGuess(Request $request)
    {
        $params = $request->all();
        unset($params['_token']);
        $data = DB::table('study_guess_record')->where(['user_id'=>$params['user_id'], 'team_id'=>$params['team_id']])->first();
        if(empty($data)){
            DB::table('study_guess_record')->insert($params);
        }else{
            DB::table('study_guess_record')->where('id',$data->id)->update($params);
        }
        
        return redirect('/study/guess/list?user_id=1');
    }
    public function checkResult(Request $request)
    {
        
        $params = $request->all();
        $guess = new Guess();
        $assign['info'] = $guess->getInfo($params['id']);
        $assign['first'] = DB::table('study_guess_record')->where(['user_id'=>$params['user_id'], 'team_id'=>$params['id']])->first();
        return view('study.guess.result',$assign);
    }
}

------------------------

<!DOCTYPE html>
<html>
<head>
    <title>足球竞猜添加页面</title>
</head>
<body style="width: 100%;">

    <div style="margin: 0px auto;">
        <form method="post" action="/study/guess/doAdd">
            {{csrf_field()}}
            <table style="width: 100%; border: #d4d4d4 1px solid">
            <tr><td style="width: 300px;text-align: center;font-weight: bold;">添加竞猜球队</td></tr>
            <tr><td style="width: 300px;text-align: center;"><input type="text" name="team_a"> VS <input type="text" name="team_b"></td></tr>
            <tr><td style="width: 300px;text-align: center;">竞猜结束时间 <input type="text" name="end_at"></td></tr>
            <tr><td style="width: 300px;text-align: center;"><input type="submit" value="添加"></td></tr>
        </table>
        </form>
        
    </div>

</body>
</html>

------------------------------------------

<!DOCTYPE html>
<html>
<head>
    <title>足球竞猜添加页面</title>
</head>
<body style="width: 100%;">

    <div style="margin: 0px auto;">
        <form method="post" action="/study/guess/doGuess">
            {{csrf_field()}}
            <input type="hidden" value="{{$user_id}}" name="user_id">
            <input type="hidden" value="{{$info['id']}}" name="team_id">
            <table style="width: 100%; border: #d4d4d4 1px solid">
            <tr><td style="width: 300px;text-align: center;font-weight: bold;">我要竞猜</td></tr>
            <tr><td style="width: 300px;text-align: center;">{{$info['team_a']}} VS {{$info['team_b']}} </td></tr>
            <tr><td style="width: 300px;text-align: center;">
                <input type="radio" name="g_result" value="1">胜
                <input type="radio" name="g_result" value="3">负
                <input type="radio" name="g_result" value="2">平
            </td></tr>
            <tr><td style="width: 300px;text-align: center;"><input type="submit" value="竞猜"></td></tr>
        </table>
        </form>
        
    </div>

</body>
</html>
-----------------------------
<!DOCTYPE html>
<html>
<head>
    <title>足球竞猜列表页面</title>
</head>
<body>

    <table style="width: 300px;">
        <thead><tr><th>球队</th><th>操作</th></tr></thead>
        <tbody style="text-align: center;">
            @if(!empty($list))
            @foreach($list as $key=>$value)
            <tr style="height: 35px;line-height: 35px;">
                <td>{{$value['team_a']}} VS {{$value['team_b']}} {{strtotime($value['end_at'])}}  - {{time()}}</td>
                <td>
                    @if(strtotime($value['end_at']) > time())
                        <a href="/study/guess/guess?id={{$value['id']}}&user_id={{$user_id}}">竞猜</a>
                    @else
                        <a href="/study/guess/result?id={{$value['id']}}&user_id={{$user_id}}">查看结果</a>
                    @endif
                </td>
            </tr>
            @endforeach
        @endif
        </tbody>
        
    </table>
</body>
</html>
---------------------------------------
<!DOCTYPE html>
<html>
<head>
    <title>足球竞猜结果页面</title>
</head>
<body style="width: 100%;">

    <div style="margin: 0px auto;">
        

            <table style="width: 100%; border: #d4d4d4 1px solid">
            <tr><td style="width: 300px;text-align: center;font-weight: bold;">查看结果</td></tr>
            <tr><td style="width: 300px;text-align: center;">对阵结果: 
             {{$info['team_a']}} 
             <font color="#ff0000">@if($info['result'] == 1) 胜 @elseif($info['result'] == 2) 平 @else 负 @endif </font>
             {{$info['team_b']}} 
         </td></tr>
            @if(!empty($first))
            <tr><td style="width: 300px;text-align: center;">您的竞猜:
            {{$info['team_a']}} 
             <font color="#ff0000">@if($first->g_result == 1) 胜 @elseif($first->g_result == 2) 平 @else 负 @endif </font>
             {{$info['team_b']}} 
            </td></tr>
            <tr>
            <td style="width: 300px;text-align: center;">结果:
                @if($first->g_result == $info['result']) 恭喜您猜中啦 @else 很抱歉没猜中 @endif
            </td>
            </tr>
            @else
            <tr>
            <td style="width: 300px;text-align: center;">结果: 您没有参与竞猜
            </td>
            </tr>
            @endif
        </table>
        
    </div>

</body>
</html>