<?php
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
// PLEASE DO NOT EDIT IT !!! THIS FILE IS GENERATED BY https://github.com/progman/reverse_orm.php
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
class reverse_orm__model__t implements ArrayAccess
{
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
	public function clear()
	{
		$this->item_list = [];
	}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
	public function push_back($item)
	{
		$this->item_list[] = $item;
	}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
	public function size()
	{
		return count($this->item_list);
	}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
	public function is_empty()
	{
		return ($this->size() === 0) ? true : false;
	}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
	public function offsetGet($offset)
	{
		return isset($this->item_list[$offset]) ? $this->item_list[$offset] : null;
//		return null;
	}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
	public function offsetSet($offset, $value)
	{
//		echo "offsetSet(): offset: ".$offset.", value: ".$value."\n";

		if ($offset === null)
		{
			$this->item_list[] = $value;
		}
		else
		{
			$this->item_list[$offset] = $value;
		}
	}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
	public function offsetExists($offset)
	{
		return isset($this->item_list[$offset]);
//		return false;
	}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
	public function offsetUnset($offset)
	{
		unset($this->item_list[$offset]);
	}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
	public function __set($name, $value)
	{
//		echo "__set(): name: ".$name.", value: ".$value."\n";

		if (count($this->item_list) === 0)
		{
			$this->item_list[] = new stdClass();
		}


		$this->item_list[0]->$name = $value;

//		print_r($this->item);
	}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
	public function __get($name)
	{
//		echo "__get(): name: ".$name."\n";

		if (count($this->item_list) === 0)
		{
			return null;
		}

		if (property_exists($this->item_list[0], $name) === false)
		{
			return null;
		}

		return $this->item_list[0]->$name;
	}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
	public function clone()
	{
//		echo "clone()\n";

		if (count($this->item_list) === 0)
		{
			return null;
		}


		return json_decode(json_encode($this->item_list[0]));
	}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
	public function get_action_list()
	{
		return array_merge($this->get_auto_action_list(), $this->get_hand_action_list());
	}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
	public function hand($arg)
	{
		$result = new result_t(__FUNCTION__, __FILE__, __LINE__);


		$name = '';
		if ($arg !== null)
		{
			if (isset($arg["name"]) !== false)
			{
				$name = $arg["name"];
			}
		}


		$func = null;
		$action_list_size = count($this->get_action_list());
		for ($i=0; $i < $action_list_size; $i++)
		{
			if (strcmp($this->get_action_list()[$i]["name"], $name) === 0)
			{
				$func = $this->get_action_list()[$i]["func"];
				break;
			}
		}


		if ($func === null)
		{
			$backtrace = debug_backtrace();
			$result = new result_t($backtrace[0]["function"], $backtrace[0]["file"], $backtrace[0]["line"]);

			$result->set_err(13, "in model for table \"".$this->get_table_name()."\", method for this filter is not exist");
			return $result;
		}


		$rc = $func($this->sql_handle, $arg);
		if ($rc->is_ok() === false)
		{
			return $rc;
		}


		$result->set_ok();
		return $result;
	}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
	private function check_item_list()
	{
		$result = new result_t(__FUNCTION__, __FILE__, __LINE__);


		$key_list = $this->get_key_list();


		$item_list_size = count($this->item_list);
		if ($item_list_size === 0)
		{
			$backtrace = debug_backtrace();
			$result = new result_t($backtrace[0]["function"], $backtrace[0]["file"], $backtrace[0]["line"]);

			$result->set_err(13, "in model for table \"".$this->get_table_name()."\", data is not found");
			return $result;
		}


		for ($i=0; $i < $item_list_size; $i++)
		{
			foreach ($key_list as $key => $value)
			{
				if (property_exists($this->item_list[$i], $key) === false)
				{
					$backtrace = debug_backtrace();
					$result = new result_t($backtrace[0]["function"], $backtrace[0]["file"], $backtrace[0]["line"]);

					$result->set_err(13, "in model for table \"".$this->get_table_name()."\", key \"".$key."\" must be set");
					return $result;
				}

				if ($value["is_nullable"] === false)
				{
					if (is_null($this->item_list[$i]->$key) === true)
					{
						$backtrace = debug_backtrace();
						$result = new result_t($backtrace[0]["function"], $backtrace[0]["file"], $backtrace[0]["line"]);

						$result->set_err(13, "in model for table \"".$this->get_table_name()."\", key \"".$key."\" must be not null");
						return $result;
					}
				}
			}
		}


		for ($i=0; $i < $item_list_size; $i++)
		{
			foreach ($this->item_list[$i] as $item_key => $item_value)
			{
				if (array_key_exists($item_key, $key_list) === false)
				{
					$backtrace = debug_backtrace();
					$result = new result_t($backtrace[0]["function"], $backtrace[0]["file"], $backtrace[0]["line"]);

					$result->set_err(13, "in model for table \"".$this->get_table_name()."\", key \"".$item_key."\" can not be exist");
					return $result;
				}
			}
		}


		$result->set_ok();
		return $result;
	}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
	private function check_handle()
	{
		$result = new result_t(__FUNCTION__, __FILE__, __LINE__);


		if ($this->sql_handle === null)
		{
			$backtrace = debug_backtrace();
			$result = new result_t($backtrace[0]["function"], $backtrace[0]["file"], $backtrace[0]["line"]);

			$result->set_err(13, "in model for table \"".$this->get_table_name()."\", sql_handle is not set in constructor");
			return $result;
		}


		$result->set_ok();
		return $result;
	}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
	private function get_arg_obj($arg)
	{
		$result = new result_t(__FUNCTION__, __FILE__, __LINE__);


		$filter_list  = new stdClass();
		$sort_list    = new stdClass();
		$offset       = null;
		$limit        = null;
//		$single       = false;
		$expect_count = false;
		$flag_lock    = false;


		if ($arg !== null)
		{
			if (isset($arg["filter"]) !== false)
			{
				foreach ($arg["filter"] as $key => $value)
				{
//					echo "key:".$key."\n";
//					echo "value:".$value."\n";

					$filter_list->$key = $value;
				}
			}


			if (isset($arg["sort"]) !== false)
			{
				foreach ($arg["sort"] as $key => $value)
				{
//					echo "key:".$key."\n";
//					echo "value:".$value."\n";

					$sort_list->$key = $value;
				}
			}


			if (isset($arg["offset"]) !== false)
			{
				if ($arg["offset"] !== false)
				{
					$offset = $arg["offset"];
				}
			}

			if (isset($arg["limit"]) !== false)
			{
				if ($arg["limit"] !== false)
				{
					$limit = $arg["limit"];
				}
			}

//			if (isset($arg["single"]) !== false)
//			{
//				if ($arg["single"] !== false)
//				{
//					$single = true;
//					$expect_count = 1;
//				}
//			}

			if (isset($arg["expect_count"]) !== false)
			{
				if (libcore__is_uint($arg["expect_count"]) !== false)
				{
					$expect_count = $arg["expect_count"];
				}
			}

			if (isset($arg["lock"]) !== false)
			{
				if ($arg["lock"] !== false)
				{
					$flag_lock = true;
				}
			}
		}


		$arg_obj = new stdClass();

		$arg_obj->filter_list  = $filter_list;
		$arg_obj->sort_list    = $sort_list;
		$arg_obj->offset       = $offset;
		$arg_obj->limit        = $limit;
//		$arg_obj->single       = $single;
		$arg_obj->expect_count = $expect_count;
		$arg_obj->flag_lock    = $flag_lock;


		$result->set_ok();
		$result->set_value($arg_obj);
		return $result;
	}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
	private function get_func($arg, $action)
	{
		$result = new result_t(__FUNCTION__, __FILE__, __LINE__);


		$request_filter_list = [];
		if ($arg !== null)
		{
			if (isset($arg["filter"]) !== false)
			{
				foreach ($arg["filter"] as $key => $value)
				{
//					echo "key:".$key."\n";
//					echo "value:".$value."\n";

					array_push($request_filter_list, $key);
				}
			}
		}
		array_multisort($request_filter_list);


		$request_sort_list = [];
		if ($arg !== null)
		{
			if (isset($arg["sort"]) !== false)
			{
				$request_sort_list = $arg["sort"];
			}
		}
		array_multisort($request_sort_list);


		$func = null;
		$action_list_size = count($this->get_action_list());
		for ($i=0; $i < $action_list_size; $i++)
		{
			if (strcmp($this->get_action_list()[$i]["type"], $action) === 0)
			{
				$func_filter_list = $this->get_action_list()[$i]["filter_list"]; // "filter_list"=> [ "id", "flag_valid" ]  <-- model request --> 'filter'=> [ 'flag_valid'=> 'true' ]
				array_multisort($func_filter_list);

				$func_sort_list = $this->get_action_list()[$i]["sort_list"]; // "sort_list"=> [ "id"=> "DESC", "flag_valid"=> "DESC" ] <-- model request --> 'sort'=> [ 'id'=> 'DESC' ]
				array_multisort($func_sort_list);


				if (libcore__cmp_value($func_filter_list, $request_filter_list) === true)
				{
					if (libcore__cmp_value($func_sort_list, $request_sort_list) === true)
					{
						$func = $this->get_action_list()[$i]["func"];
						break;
					}
				}
			}
		}


		if ($func === null)
		{
			$backtrace = debug_backtrace();
			$result = new result_t($backtrace[0]["function"], $backtrace[0]["file"], $backtrace[0]["line"]);

			$result->set_err(13, "in model for table \"".$this->get_table_name()."\", method for this filter is not exist");
			return $result;
		}


		$result->set_ok();
		$result->set_value($func);
		return $result;
	}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
	public function add($arg = null)
	{
		$result = new result_t(__FUNCTION__, __FILE__, __LINE__);


		$action = "ADD";


		$rc = $this->get_arg_obj($arg);
		if ($rc->is_ok() === false) return $rc;
		$arg_obj = $rc->get_value();


		$rc = $this->check_handle();
		if ($rc->is_ok() === false) return $rc;


		$rc = $this->check_item_list();
		if ($rc->is_ok() === false) return $rc;


		$rc = $this->get_func($arg, $action);
		if ($rc->is_ok() === false) return $rc;
		$func = $rc->get_value();


		if ($this->flag_debug !== false)
		{
			echo "use ".$func."() for ".$action."\n";
		}


		$item_list_size = count($this->item_list);
		for ($i=0; $i < $item_list_size; $i++)
		{
			$rc = $func($this->sql_handle, $this->item_list[$i], $arg_obj->filter_list, $arg_obj->sort_list, $arg_obj->offset, $arg_obj->limit, $arg_obj->flag_lock);
			if ($rc->is_ok() === false)
			{
				$this->clear();
				return $rc;
			}
		}


		$this->clear();


		$result->set_ok();
		return $result;
	}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
	public function set($arg = null)
	{
		$result = new result_t(__FUNCTION__, __FILE__, __LINE__);


		$action = "SET";


		$rc = $this->get_arg_obj($arg);
		if ($rc->is_ok() === false) return $rc;
		$arg_obj = $rc->get_value();


		$rc = $this->check_handle();
		if ($rc->is_ok() === false) return $rc;


		$rc = $this->check_item_list();
		if ($rc->is_ok() === false) return $rc;


		$rc = $this->get_func($arg, $action);
		if ($rc->is_ok() === false) return $rc;
		$func = $rc->get_value();


		if ($this->flag_debug !== false)
		{
			echo "use ".$func."() for ".$action."\n";
		}


		$item_list_size = count($this->item_list);
		for ($i=0; $i < $item_list_size; $i++)
		{
			$rc = $func($this->sql_handle, $this->item_list[$i], $arg_obj->filter_list, $arg_obj->sort_list, $arg_obj->offset, $arg_obj->limit, $arg_obj->flag_lock);
			if ($rc->is_ok() === false)
			{
				$this->clear();
				return $rc;
			}
		}


		$this->clear();


		$result->set_ok();
		return $result;
	}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
	public function cnt($arg = null)
	{
		$result = new result_t(__FUNCTION__, __FILE__, __LINE__);


		$action = "CNT";


		$rc = $this->get_arg_obj($arg);
		if ($rc->is_ok() === false) return $rc;
		$arg_obj = $rc->get_value();


		$rc = $this->check_handle();
		if ($rc->is_ok() === false) return $rc;


//		$rc = $this->check_item_list();
//		if ($rc->is_ok() === false) return $rc;


		$rc = $this->get_func($arg, $action);
		if ($rc->is_ok() === false) return $rc;
		$func = $rc->get_value();


		if ($this->flag_debug !== false)
		{
			echo "use ".$func."() for ".$action."\n";
		}


		$rc = $func($this->sql_handle, null, $arg_obj->filter_list, $arg_obj->sort_list, $arg_obj->offset, $arg_obj->limit, $arg_obj->flag_lock);
		if ($rc->is_ok() === false)
		{
			return $rc;
		}
		$value = $rc->get_value();


		$result->set_ok();
		$result->set_value($value);
		return $result;
	}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
	public function get($arg = null)
	{
		$result = new result_t(__FUNCTION__, __FILE__, __LINE__);


		$action = "GET";


		$rc = $this->get_arg_obj($arg);
		if ($rc->is_ok() === false) return $rc;
		$arg_obj = $rc->get_value();


		$rc = $this->check_handle();
		if ($rc->is_ok() === false) return $rc;


//		$rc = $this->check_item_list();
//		if ($rc->is_ok() === false) return $rc;


		$rc = $this->get_func($arg, $action);
		if ($rc->is_ok() === false) return $rc;
		$func = $rc->get_value();


		if ($this->flag_debug !== false)
		{
			echo "use ".$func."() for ".$action."\n";
		}


		$this->clear();


		$rc = $func($this->sql_handle, null, $arg_obj->filter_list, $arg_obj->sort_list, $arg_obj->offset, $arg_obj->limit, $arg_obj->flag_lock);
		if ($rc->is_ok() === true)
		{
//			if ($arg_obj->single !== false)
//			{
//				if (count($rc->get_value()) !== 1)
//				{
//					$result->set_err(13, "in model for table \"".$this->get_table_name()."\", we did not get one row");
//					return $result;
//				}
//			}


			$count = count($rc->get_value());
			if ($arg_obj->expect_count !== false)
			{
				if ($count !== $arg_obj->expect_count)
				{
					$result->set_err(13, "in model for table \"".$this->get_table_name()."\", we expected ".$arg_obj->expect_count." rows, but ".$count." in fact");
					return $result;
				}
			}


			$this->item_list = $rc->get_value();
		}


		return $rc;
	}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
	public function del($arg = null)
	{
		$result = new result_t(__FUNCTION__, __FILE__, __LINE__);


		$action = "DEL";


		$rc = $this->get_arg_obj($arg);
		if ($rc->is_ok() === false) return $rc;
		$arg_obj = $rc->get_value();


		$rc = $this->check_handle();
		if ($rc->is_ok() === false) return $rc;


//		$rc = $this->check_item_list();
//		if ($rc->is_ok() === false) return $rc;


		$rc = $this->get_func($arg, $action);
		if ($rc->is_ok() === false) return $rc;
		$func = $rc->get_value();


		if ($this->flag_debug !== false)
		{
			echo "use ".$func."() for ".$action."\n";
		}


		$this->clear();


		$rc = $func($this->sql_handle, null, $arg_obj->filter_list, $arg_obj->sort_list, $arg_obj->offset, $arg_obj->limit, $arg_obj->flag_lock);
		if ($rc->is_ok() === false)
		{
			return $rc;
		}


		$result->set_ok();
		return $result;
	}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
	public function lck($arg = null)
	{
		$result = new result_t(__FUNCTION__, __FILE__, __LINE__);


		$action = "LCK";


		$rc = $this->get_arg_obj($arg);
		if ($rc->is_ok() === false) return $rc;
		$arg_obj = $rc->get_value();


		$rc = $this->check_handle();
		if ($rc->is_ok() === false) return $rc;


//		$rc = $this->check_item_list();
//		if ($rc->is_ok() === false) return $rc;


		$rc = $this->get_func($arg, $action);
		if ($rc->is_ok() === false) return $rc;
		$func = $rc->get_value();


		if ($this->flag_debug !== false)
		{
			echo "use ".$func."() for ".$action."\n";
		}


		$this->clear();


		$rc = $func($this->sql_handle);
		if ($rc->is_ok() === false)
		{
			return $rc;
		}


		$result->set_ok();
		return $result;
	}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
?>