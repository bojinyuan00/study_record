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



//删除数组的第一个元素并返回值
array_shift($path_arr);



//当使用关联模型查询时
  $coll = $coll
            ->with('engineering')
            ->with('construction_type')
            ->orderBy('id')
            ->paginate($request->page_size ?? 10);
        
        list($data,$total) = ArrLib::listDataTotal($coll);
        // dd($data);
        //获取关联模型内想要获取的字段，并且命名
        ArrLib::newBeeMethod($data,1,'engineering.title', 'engineering.eng_type_id', 'construction_type.name');
    	
    	///对数组内的某些字段进行转化重命名
        ArrLib::renameColumn($data, 'engineering_title->engineeringTitle');

        // 用于上面调用
		public static function newBeeMethod(&$coll, $is_need_unset, ...$column_paths)
		    {
		        if (!is_array($coll)) {
		            $coll = $coll->toArray();
		        }
		        if ($coll == []) {
		            return;
		        }
		        if (isset($coll[0])) {
		            //二维数组
		            foreach ($coll as &$obj) {
		                foreach ($column_paths as $path) {
		                    self::newBeeAppend($path, $obj);
		                }
		            }
		            if ($is_need_unset) {
		                foreach ($coll as &$obj) {
		                    foreach ($column_paths as $path) {
		                        self::newBeeUnset($path, $obj);
		                    }
		                }
		            }
		        } else {
		            //一维数组
		            foreach ($column_paths as $path) {
		                self::newBeeAppend($path, $coll);
		            }
		            if ($is_need_unset) {
		                foreach ($column_paths as $path) {
		                    self::newBeeUnset($path, $coll);
		                }
		            }
		        }
		    }

		    //用于上面调用
		    protected static function newBeeAppend($path, &$obj)
			    {
			        $path_arr = explode('.', $path);
			        $obj[$path_arr[count($path_arr) - 2] . '_' . $path_arr[count($path_arr) - 1]] = self::dataGet($obj, $path_arr);
			    }
			//用于上面调用   
			    protected static function newBeeUnset($path, &$obj)
			    {
			        $path_arr = explode('.', $path);
			        unset($obj[$path_arr[0]]);
			    }
			//用于上面调用    
			    public static function dataGet($obj, $path_arr)
			    {
			        $temp = $obj[$path_arr[0]];
			        if (count($path_arr) == 1) {
			            return $temp;
			        } else {
			            array_shift($path_arr);
			            return self::dataGet($temp, $path_arr);
			        }
			    }



			///用于重命名调用
			 /**
		     * @param $coll
		     * @param mixed ...$from_to a->b
		     */
		    public static function renameColumn(&$coll, ...$from_to)
		    {
		        if ($coll == []) {
		            return;
		        }
		        if (isset($coll[0])) {
		            foreach ($coll as &$obj) {
		                foreach ($from_to as $ft) {
		                    self::rename1($ft, $obj);
		                }
		            }
		        } else {
		            foreach ($from_to as $ft) {
		                self::rename1($ft, $coll);
		            }
		        }
		    }
		    
		    protected static function rename1($ft, &$obj)
		    {
		        $arr = explode('->', $ft);
		        $from = $arr[0];
		        $to = $arr[1];
		        $obj[$to] = $obj[$from];
		        unset($obj[$from]);
		    }



