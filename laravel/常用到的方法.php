<?php



//根据某个id获取与它相关联的其他id数组   可以得到一个id数组，并且自动转化为一维
$data_propartment= BureauPropartment::query()
    ->where('bureau_id', $bureau_id)
    ->select('id')
    ->get()
    ->pluck('id')
    ->toArray();

//根据某个id数组，查询某表内与它相关联的id数组，并且转化为一维数组
$data_propartment_x_project= BureauPropartmentXProject::query()
    ->whereIn('bureau_propartment_id', $data_propartment)
    ->select('project_id')
    ->get()
    ->pluck('project_id')
    ->toArray();

//一维数组，统计每个值出现的次数
$data=array_count_values($data_train);

//根据项目数组获取机具的id数组==》获取每个id对应的类别数组
$data_moving_machine = MovingMachine::query()
        ->whereIn('project_id', $res)
        ->select('id','type')
        ->get()
        ->pluck('type','id')
        ->toArray();
    $data_moving_machine=array_count_values($data_moving_machine);
	$train['sz_nums']   = $data_moving_machine['1'] ?? 0;//石渣机具数量
	$train['zbpb_nums'] = $data_moving_machine['2'] ?? 0;//自备平板机具数量
	$train['lypb_nums'] = $data_moving_machine['3'] ?? 0;//路用平板机具数量
	$train['yypb_nums'] = $data_moving_machine['4'] ?? 0;//运用平板机具数量



