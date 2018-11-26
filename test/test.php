<?php
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
require_once("../submodule/libcore.php/libcore.php");
require_once("../submodule/libsql_postgresql.php/libsql_postgresql.php");

require_once("../reverse_orm__model.php");
require_once("test_reverse_orm/model_mix.php");
require_once("test_reverse_orm/sql_mix.php");
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
$arg = new stdClass();

$arg->callback      = libcore__get_var_str("callback");
$arg->sql_host      = libcore__get_var_str("SQL_HOST");
$arg->sql_port      = libcore__get_var_str("SQL_PORT");
$arg->sql_database  = libcore__get_var_str("SQL_DATABASE");
$arg->sql_login     = libcore__get_var_str("SQL_LOGIN");
$arg->sql_password  = libcore__get_var_str("SQL_PASSWORD");
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function do_it($arg)
{
	$result = new result_t(__FUNCTION__, __FILE__);


	$public__test = new public__test__t($arg->sql_handle, true);


	echo "-[test0001]-----------------------------------------------\n";
	$public__test->id         = '01';           // id          | bytea     | NOT NULL
	$public__test->value      = new stdClass(); // value       | json      | NOT NULL
	$public__test->flag_valid = '1';            // flag_valid  | boolean   | NOT NULL

	$rc = $public__test->add();
	if ($rc->is_ok() === false) return $rc;


	echo "-[test0002]-----------------------------------------------\n";
	$public__test->id         = '02';           // id          | bytea     | NOT NULL
	$public__test->value      = new stdClass(); // value       | json      | NOT NULL
	$public__test->flag_valid = '1';            // flag_valid  | boolean   | NOT NULL

	$rc = $public__test->add();
	if ($rc->is_ok() === false) return $rc;


	echo "-[test0003]-----------------------------------------------\n";
	$public__test->id         = '03';           // id          | bytea     | NOT NULL
	$public__test->value      = new stdClass(); // value       | json      | NOT NULL
	$public__test->flag_valid = '1';            // flag_valid  | boolean   | NOT NULL

	$rc = $public__test->add();
	if ($rc->is_ok() === false) return $rc;


	echo "-[test0004]-----------------------------------------------\n";
	$rc = $public__test->cnt([ "filter"=> [ "flag_valid"=> "true" ] ]);
	if ($rc->is_ok() === false) return $rc;
	$count = $rc->get_value();
	echo "count: ".$count."\n";


	echo "-[test0005]-----------------------------------------------\n";
	$rc = $public__test->cnt([ "filter"=> [ "flag_valid"=> "true", "id"=> "01" ] ]);
	if ($rc->is_ok() === false) return $rc;
	$count = $rc->get_value();
	echo "count: ".$count."\n";


	echo "-[test0006]-----------------------------------------------\n";
	$rc = $public__test->get([ "filter"=> [ "flag_valid"=> "true" ], "sort"=> [ "id"=> "DESC" ], "expect_count"=> null, "lock"=> false ]);
	if ($rc->is_ok() === false) return $rc;
	$count = $rc->get_value();
	echo "count: ".print_r($count, true)."\n";


	echo "-[test0007]-----------------------------------------------\n";
	$rc = $public__test->get([ "filter"=> [ "id"=> "03" ], "expect_count"=> 1, "lock"=> false ]);
	if ($rc->is_ok() === false) return $rc;
	$obj_list = $rc->get_value();
	echo "obj_list: ".print_r($obj_list, true)."\n";


	echo "-[test0008]-----------------------------------------------\n";
	if (strcmp($public__test->flag_valid, '0') === 0)
	{
		$public__test->flag_valid = '1';
	}
	else
	{
		$public__test->flag_valid = '0';
	}
	$rc = $public__test->set([ "filter"=> [ "id"=> "03" ] ]);
	if ($rc->is_ok() === false) return $rc;


	echo "-[test0009]-----------------------------------------------\n";
	$rc = $public__test->cnt([ "filter"=> [ "flag_valid"=> "true" ] ]);
	if ($rc->is_ok() === false) return $rc;
	$count = $rc->get_value();
	echo "count: ".$count."\n";


	echo "-[test0010]-----------------------------------------------\n";
	$rc = $public__test->cnt();
	if ($rc->is_ok() === false) return $rc;
	$count = $rc->get_value();
	echo "count: ".$count."\n";


	echo "-[test0011]-----------------------------------------------\n";
	$rc = $public__test->del([ "filter"=> [ "id"=> "0" ] ]);
	if ($rc->is_ok() === false) return $rc;


	echo "-[test0012]-----------------------------------------------\n";
	$rc = $public__test->cnt();
	if ($rc->is_ok() === false) return $rc;
	$count = $rc->get_value();
	echo "count: ".$count."\n";


	echo "-[test0013]-----------------------------------------------\n";
	$rc = $public__test->del();
	if ($rc->is_ok() === false) return $rc;


	echo "-[test0014]-----------------------------------------------\n";
	$rc = $public__test->cnt();
	if ($rc->is_ok() === false) return $rc;
	$count = $rc->get_value();
	echo "count: ".$count."\n";


	echo "-[test0015]-----------------------------------------------\n";
	$rc = $public__test->lck();
	if ($rc->is_ok() === false) return $rc;


//	$rc = $public__test->hand([ 'name'=> 'HAND_0001' ] );
//	if ($rc->is_ok() === false) return $rc;


	$result->set_ok();
	return $result;
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function action($arg)
{
	$result = new result_t(__FUNCTION__, __FILE__);


// begin transaction
	$rc = libsql__transaction_begin($arg->sql_handle);
	if ($rc->is_ok() === false) return $rc;


	$rc = do_it($arg);
	if ($rc->is_ok() === false)
	{
		libsql__transaction_rollback($arg->sql_handle);
		return $rc;
	}
	$value = $rc->get_value();


// commit transaction
	$rc = libsql__transaction_commit($arg->sql_handle);
	if ($rc->is_ok() === false)
	{
		libsql__transaction_rollback($arg->sql_handle);
		return $rc;
	}


	$result->set_ok();
	$result->set_value($value);
	return $result;
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function main($arg)
{
	$result = new result_t(__FUNCTION__, __FILE__);


// check sql args
	if (isset($arg->sql_host) === false)
	{
		$result->set_err(1, 'you should set SQL_HOST');
		return $result;
	}

	if (isset($arg->sql_port) === false)
	{
		$result->set_err(1, 'you should set SQL_PORT');
		return $result;
	}

	if (isset($arg->sql_database) === false)
	{
		$result->set_err(1, 'you should set SQL_DATABASE');
		return $result;
	}

	if (isset($arg->sql_login) === false)
	{
		$result->set_err(1, 'you should set SQL_LOGIN');
		return $result;
	}

	if (isset($arg->sql_password) === false)
	{
		$result->set_err(1, 'you should set SQL_PASSWORD');
		return $result;
	}


// set sql handle
	$arg->sql_handle = null;


// connect to sql database
	$rc = libsql__database_open($arg->sql_host, $arg->sql_port, $arg->sql_database, $arg->sql_login, $arg->sql_password);
	if ($rc->is_ok() === false) return $rc;
	$arg->sql_handle = $rc->get_value();


	$result = action($arg);


// disconnect from sql database
	libsql__database_close($arg->sql_handle);


	return $result;
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
$rc = main($arg);
if ($rc->is_ok() === false)
{
	echo libcore__draw_time()."ERROR[".$rc->get_function_name()."()]: ".$rc->get_msg()."\n";

	exit(1);
}
exit(0);
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
?>