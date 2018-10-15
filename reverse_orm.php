<?php
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
// 1.0.5
// Alexey Potehin <gnuplanet@gmail.com>, http://www.gnuplanet.online/doc/cv
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
require_once("submodule/libcore.php/libcore.php");
require_once("submodule/libsql_postgresql.php/libsql_postgresql.php");
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
$arg = new stdClass();

$arg->config        = libcore__get_var_str("CONFIG");
$arg->target_dir    = libcore__get_var_str("TARGET_DIR", ".");
$arg->link_list     = libcore__get_var_str("LINK_LIST");

$arg->callback      = libcore__get_var_str("callback");

$arg->sql_host      = libcore__get_var_str("SQL_HOST");
$arg->sql_port      = libcore__get_var_str("SQL_PORT");
$arg->sql_database  = libcore__get_var_str("SQL_DATABASE");
$arg->sql_login     = libcore__get_var_str("SQL_LOGIN");
$arg->sql_password  = libcore__get_var_str("SQL_PASSWORD");
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function add_dir($dir_name)
{
	$result = new result_t(__FUNCTION__, __FILE__);


// make dir
	if (@file_exists($dir_name) === true)
	{
		$result->set_ok();
		return $result;
	}


	$rc = @mkdir($dir_name);
	if ($rc === false)
	{
		$result->set_err(1, 'can not add dir');
		return $result;
	}


	$result->set_ok();
	return $result;
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function del_dir($dir_name)
{
	$result = new result_t(__FUNCTION__, __FILE__);


// make dir
	if (@file_exists($dir_name) === false)
	{
		$result->set_ok();
		return $result;
	}


/*
	$rc = @rmdir($dir_name);
	if ($rc === false)
	{
		$result->set_err(1, 'can not rm dir');
		return $result;
	}
*/


	@exec("rm -rf ".$dir_name);


	$result->set_ok();
	return $result;
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function prepare_store($arg)
{
	$result = new result_t(__FUNCTION__, __FILE__);


	$target_dir       = $arg->target_dir;
	$server_name      = $arg->server_name;
	$table_schema     = $arg->table_schema;
	$table_name       = $arg->table_name;


// make dir
	$rc = add_dir($target_dir.'/'.$server_name);
	if ($rc->is_ok() === false) return $rc;


//	$rc = @getcwd();
//	if ($rc === false)
//	{
//		$result->set_err(1, 'can not get cur dir');
//		return $result;
//	}
//	$cur_dir = $rc;


	$rc = add_dir($target_dir.'/'.$server_name.'/HAND');
	if ($rc->is_ok() === false) return $rc;


	$rc = add_dir($target_dir.'/'.$server_name.'/'.$table_schema.'.'.$table_name);
	if ($rc->is_ok() === false) return $rc;


/*
	$rc = @chdir($table_schema.'.'.$table_name);
	if ($rc === false)
	{
		$result->set_err(1, 'can not change dir');
		return $result;
	}
*/


	$rc = add_dir($target_dir.'/'.$server_name.'/'.$table_schema.'.'.$table_name.'/HAND');
	if ($rc->is_ok() === false) return $rc;




	$rc = add_dir($target_dir.'/'.$server_name.'/'.$table_schema.'.'.$table_name.'/add'); // insert
	if ($rc->is_ok() === false) return $rc;

	$rc = del_dir($target_dir.'/'.$server_name.'/'.$table_schema.'.'.$table_name.'/add'.'/auto');
	if ($rc->is_ok() === false) return $rc;

	$rc = add_dir($target_dir.'/'.$server_name.'/'.$table_schema.'.'.$table_name.'/add'.'/auto');
	if ($rc->is_ok() === false) return $rc;

	$rc = add_dir($target_dir.'/'.$server_name.'/'.$table_schema.'.'.$table_name.'/add'.'/hand');
	if ($rc->is_ok() === false) return $rc;




	$rc = add_dir($target_dir.'/'.$server_name.'/'.$table_schema.'.'.$table_name.'/set'); // update
	if ($rc->is_ok() === false) return $rc;

	$rc = del_dir($target_dir.'/'.$server_name.'/'.$table_schema.'.'.$table_name.'/set'.'/auto');
	if ($rc->is_ok() === false) return $rc;

	$rc = add_dir($target_dir.'/'.$server_name.'/'.$table_schema.'.'.$table_name.'/set'.'/auto');
	if ($rc->is_ok() === false) return $rc;

	$rc = add_dir($target_dir.'/'.$server_name.'/'.$table_schema.'.'.$table_name.'/set'.'/hand');




	$rc = add_dir($target_dir.'/'.$server_name.'/'.$table_schema.'.'.$table_name.'/cnt'); // select_count
	if ($rc->is_ok() === false) return $rc;

	$rc = del_dir($target_dir.'/'.$server_name.'/'.$table_schema.'.'.$table_name.'/cnt'.'/auto');
	if ($rc->is_ok() === false) return $rc;

	$rc = add_dir($target_dir.'/'.$server_name.'/'.$table_schema.'.'.$table_name.'/cnt'.'/auto');
	if ($rc->is_ok() === false) return $rc;

	$rc = add_dir($target_dir.'/'.$server_name.'/'.$table_schema.'.'.$table_name.'/cnt'.'/hand');
	if ($rc->is_ok() === false) return $rc;




	$rc = add_dir($target_dir.'/'.$server_name.'/'.$table_schema.'.'.$table_name.'/get'); // select_list
	if ($rc->is_ok() === false) return $rc;

	$rc = del_dir($target_dir.'/'.$server_name.'/'.$table_schema.'.'.$table_name.'/get'.'/auto');
	if ($rc->is_ok() === false) return $rc;

	$rc = add_dir($target_dir.'/'.$server_name.'/'.$table_schema.'.'.$table_name.'/get'.'/auto');
	if ($rc->is_ok() === false) return $rc;

	$rc = add_dir($target_dir.'/'.$server_name.'/'.$table_schema.'.'.$table_name.'/get'.'/hand');
	if ($rc->is_ok() === false) return $rc;




	$rc = add_dir($target_dir.'/'.$server_name.'/'.$table_schema.'.'.$table_name.'/del'); // delete
	if ($rc->is_ok() === false) return $rc;

	$rc = del_dir($target_dir.'/'.$server_name.'/'.$table_schema.'.'.$table_name.'/del'.'/auto');
	if ($rc->is_ok() === false) return $rc;

	$rc = add_dir($target_dir.'/'.$server_name.'/'.$table_schema.'.'.$table_name.'/del'.'/auto');
	if ($rc->is_ok() === false) return $rc;

	$rc = add_dir($target_dir.'/'.$server_name.'/'.$table_schema.'.'.$table_name.'/del'.'/hand');
	if ($rc->is_ok() === false) return $rc;


	$result->set_ok();
	return $result;
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
/*
SELECT table_schema, table_name, ordinal_position, column_name, column_default, data_type, udt_name, is_nullable, is_generated, is_updatable FROM INFORMATION_SCHEMA.COLUMNS 
WHERE table_schema='main' and table_name = 'role' order by ordinal_position;
 table_schema | table_name | ordinal_position |     column_name      | column_default |          data_type          | udt_name  | is_nullable | is_generated | is_updatable 
--------------+------------+------------------+----------------------+----------------+-----------------------------+-----------+-------------+--------------+--------------
 main         | role       |                1 | id                   |                | bytea                       | bytea     | NO          | NEVER        | YES
 main         | role       |                2 | type_id_list         |                | ARRAY                       | _bytea    | YES         | NEVER        | YES
 main         | role       |                3 | type_name_list       |                | ARRAY                       | _text     | NO          | NEVER        | YES
 main         | role       |                4 | session_id           |                | bytea                       | bytea     | YES         | NEVER        | YES
 main         | role       |                5 | password_hash        |                | text                        | text      | YES         | NEVER        | YES
 main         | role       |                6 | email                |                | text                        | text      | NO          | NEVER        | YES
 main         | role       |                7 | phone                |                | text                        | text      | NO          | NEVER        | YES
 main         | role       |                8 | email_key            |                | bytea                       | bytea     | YES         | NEVER        | YES
 main         | role       |                9 | phone_key            |                | text                        | text      | YES         | NEVER        | YES
 main         | role       |               10 | profile_id           |                | bytea                       | bytea     | NO          | NEVER        | YES
 main         | role       |               11 | boss_id_list         |                | ARRAY                       | _bytea    | YES         | NEVER        | YES
 main         | role       |               12 | flag_phone_confirmed |                | boolean                     | bool      | NO          | NEVER        | YES
 main         | role       |               13 | flag_email_confirmed |                | boolean                     | bool      | NO          | NEVER        | YES
 main         | role       |               14 | utc_offset           |                | bigint                      | int8      | NO          | NEVER        | YES
 main         | role       |               19 | meta                 |                | jsonb                       | jsonb     | NO          | NEVER        | YES
 main         | role       |               24 | ctime                |                | timestamp without time zone | timestamp | NO          | NEVER        | YES
 main         | role       |               25 | mtime                |                | timestamp without time zone | timestamp | NO          | NEVER        | YES
 main         | role       |               26 | flag_enable          |                | boolean                     | bool      | NO          | NEVER        | YES
 main         | role       |               27 | flag_valid           |                | boolean                     | bool      | NO          | NEVER        | YES
*/
function sql_select_list__table_columns($sql_handle, $table_schema, $table_name)
{
	$result = new result_t(__FUNCTION__, __FILE__);
	$item_list = array();


	$sql_tag = "SQLXXX".__FUNCTION__;
	$sql_str = "
SELECT
		cols.ordinal_position::bigint AS ordinal_position,
		cols.table_schema::text       AS table_schema,
		cols.table_name::text         AS table_name,
		cols.column_name::text        AS column_name,
		cols.column_default::text     AS column_default,
		cols.data_type::text          AS data_type,
		cols.udt_name::text           AS udt_name,
		cols.is_nullable::text        AS is_nullable,
		cols.is_generated::text       AS is_generated,
		cols.is_updatable::text       AS is_updatable,
		(
			SELECT
					pg_catalog.col_description(c.oid, cols.ordinal_position::int)
			FROM
					pg_catalog.pg_class AS c
			WHERE
					c.oid = (SELECT (cols.table_schema || '.' || cols.table_name)::regclass::oid)
					AND c.relname = cols.table_name
		) AS column_comment
FROM
		information_schema.columns AS cols
WHERE
		cols.table_schema = ".libsql__var2text($table_schema)."
		AND cols.table_name = ".libsql__var2text($table_name)."
ORDER BY cols.ordinal_position; -- ".$sql_tag."
";

	$sql_result = libsql__query($sql_handle, $sql_tag, $sql_str, $result);
	if ($sql_result === false)
	{
		$result->set_err(1, "sql error", libsql__error($sql_handle));
		return $result;
	}

	if (libsql__num_rows($sql_result) !== 0)
	{
		while ($row = @pg_fetch_array($sql_result))
		{
			$item                   = new stdClass;

			$item->ordinal_position = $row["ordinal_position"];
			$item->table_schema     = $row["table_schema"];
			$item->table_name       = $row["table_name"];
			$item->column_name      = $row["column_name"];
			$item->column_default   = $row["column_default"];
			$item->data_type        = $row["data_type"];
			$item->udt_name         = $row["udt_name"];
			$item->is_nullable      = $row["is_nullable"];
			$item->is_generated     = $row["is_generated"];
			$item->is_updatable     = $row["is_updatable"];
			$item->column_comment   = $row["column_comment"];

			array_push($item_list, $item);
		}
	}
	libsql__query_free($sql_result);


	$result->set_ok();
	$result->set_value($item_list);
	return $result;
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
/*
 table_schema | table_name | constraint_name | column_name 
--------------+------------+-----------------+-------------
 public       | client     | client_pkey     | id
(1 строка)
*/
function sql_select_list__table_pks($sql_handle, $table_schema, $table_name)
{
	$result = new result_t(__FUNCTION__, __FILE__);
	$item_list = array();


	$sql_tag = "SQLXXX".__FUNCTION__;

	$sql_str = "
SELECT
		t.table_schema,
		t.table_name,
		kcu.constraint_name,
		kcu.column_name
FROM
		information_schema.tables AS t
		LEFT JOIN information_schema.table_constraints AS tc ON
		(
			tc.table_catalog = t.table_catalog
			AND tc.table_schema = t.table_schema
			AND tc.table_name = t.table_name
			AND tc.constraint_type = 'PRIMARY KEY'
		)
		LEFT JOIN information_schema.key_column_usage AS kcu ON
		(
			kcu.table_catalog = tc.table_catalog
			AND kcu.table_schema = tc.table_schema
			AND kcu.table_name = tc.table_name
			AND kcu.constraint_name = tc.constraint_name
		)
WHERE
		t.table_schema NOT IN ('pg_catalog', 'information_schema')
		AND t.table_schema = ".libsql__var2text($table_schema)."
		AND t.table_name = ".libsql__var2text($table_name)."
ORDER BY kcu.ordinal_position; -- ".$sql_tag."
";

	$sql_result = libsql__query($sql_handle, $sql_tag, $sql_str, $result);
	if ($sql_result === false)
	{
		$result->set_err(1, "sql error", libsql__error($sql_handle));
		return $result;
	}

	if (libsql__num_rows($sql_result) !== 0)
	{
		while ($row = @pg_fetch_array($sql_result))
		{
			$item = $row["column_name"];

			array_push($item_list, $item);
		}
	}
	libsql__query_free($sql_result);


	$result->set_ok();
	$result->set_value($item_list);
	return $result;
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function make_line()
{
	$tmp = '';
	$tmp .= '//';

	for ($i=0; $i < 307; $i++)
	{
		$tmp .= '-';
	}

	$tmp .= '//';
	$tmp .= "\n";

	return $tmp;
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function spacer1($table_columns_list, $index)
{
	$column_name_size_max = 0;

	$table_columns_list_size = count($table_columns_list);
	for ($i=0; $i < $table_columns_list_size; $i++)
	{
		$column_name_size = strlen($table_columns_list[$i]->column_name);
		if ($column_name_size > $column_name_size_max)
		{
			$column_name_size_max = $column_name_size;
		}
	}

	$column_name_size_cur = strlen($table_columns_list[$index]->column_name);
//	$column_name_size_cur++;
	$size = $column_name_size_max - $column_name_size_cur + 1;
	$tmp = '';
	for ($i=0; $i < $size; $i++)
	{
		$tmp .= ' ';
	}

	return $tmp;
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function spacer2($name, $max_name_size)
{
	$size = $max_name_size - strlen($name);
	$tmp = '';

	for ($i=0; $i < $size; $i++)
	{
		$tmp .= ' ';
	}

	return $tmp;
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function generate_insert($arg, $plan)
{
	$result = new result_t(__FUNCTION__, __FILE__);


	$target_dir         = $arg->target_dir;
	$server_name        = $arg->server_name;
	$table_schema       = $arg->table_schema;
	$table_name         = $arg->table_name;
	$table_columns_list = $arg->table_columns_list;
	$table_name_short   = $arg->table_name_short;
	$model_name         = $arg->model_name;


	$table_columns_list_size = count($table_columns_list);


	$tmp  = make_line();
	$tmp .= '// PLEASE DO NOT EDIT IT !!! THIS FILE IS GENERATED BY https://github.com/progman/reverse_orm.php'."\n";
	$tmp .= make_line();
	$tmp .= 'function sql_orm_add__'.$table_schema.'__'.$table_name.'__'.$plan->name.'($sql_handle, $obj, $filter_list, $sort_list, $offset, $limit, $flag_lock = false)'."\n";
	$tmp .= '{'."\n";
	$tmp .= '	$result = new result_t(__FUNCTION__, __FILE__);'."\n";
	$tmp .= '//	$item = null;'."\n";
	$tmp .= ''."\n";
	$tmp .= ''."\n";
	$tmp .= '	$sql_tag = "SQLXXX".__FUNCTION__;'."\n";
	$tmp .= '	$sql_str = "'."\n";
	$tmp .= 'INSERT INTO '.$table_schema.'.'.$table_name."\n";
	$tmp .= '('."\n";

	for ($i=0; $i < $table_columns_list_size; $i++)
	{
		$line = '		'.$table_columns_list[$i]->column_name;

		if (($i + 1) !== $table_columns_list_size)
		{
			$tmp .= $line.','."\n";
		}
		else
		{
			$tmp .= $line."\n";
		}
	}

	$tmp .= ')'."\n";
	$tmp .= 'VALUES'."\n";
	$tmp .= '('."\n";

	for ($i=0; $i < $table_columns_list_size; $i++)
	{
		$line = '';
		$flag_found = false;
		for (;;)
		{
			if (strcmp($table_columns_list[$i]->data_type_real, 'bytea') === 0)
			{
				$line .= '		".libsql__var2bytea      ($obj->'.$table_columns_list[$i]->column_name.')."';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'bytea[]') === 0)
			{
				$line .= '		".libsql__var2bytea_list ($obj->'.$table_columns_list[$i]->column_name.')."';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'text') === 0)
			{
				$line .= '		".libsql__var2text       ($obj->'.$table_columns_list[$i]->column_name.')."';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'text[]') === 0)
			{
				$line .= '		".libsql__var2text_list  ($obj->'.$table_columns_list[$i]->column_name.')."';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'json') === 0)
			{
				$line .= '		".libsql__var2json       ($obj->'.$table_columns_list[$i]->column_name.')."';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'json[]') === 0)
			{
				$line .= '		".libsql__var2json_list  ($obj->'.$table_columns_list[$i]->column_name.')."';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'bigint') === 0)
			{
				$line .= '		".libsql__var2bigint     ($obj->'.$table_columns_list[$i]->column_name.')."';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'bigint[]') === 0)
			{
				$line .= '		".libsql__var2bigint_list($obj->'.$table_columns_list[$i]->column_name.')."';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'timestamp') === 0)
			{
				$line .= '		".libsql__var2time       ($obj->'.$table_columns_list[$i]->column_name.')."';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'timestamp[]') === 0)
			{
				$line .= '		".libsql__var2time_list  ($obj->'.$table_columns_list[$i]->column_name.')."';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'boolean') === 0)
			{
				$line .= '		".libsql__var2bool       ($obj->'.$table_columns_list[$i]->column_name.')."';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'boolean[]') === 0)
			{
				$line .= '		".libsql__var2bool_list  ($obj->'.$table_columns_list[$i]->column_name.')."';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'uuid') === 0)
			{
				$line .= '		".libsql__var2uuid       ($obj->'.$table_columns_list[$i]->column_name.')."';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'uuid[]') === 0)
			{
				$line .= '		".libsql__var2uuid_list  ($obj->'.$table_columns_list[$i]->column_name.')."';
				$flag_found = true;
				break;
			}

			break;
		}
		if ($flag_found === false)
		{
			$result->set_err(1, 'data_type "'.$table_columns_list[$i]->data_type_real.'" is unknown');
			return $result;
		}


		if (($i + 1) !== $table_columns_list_size)
		{
			$tmp .= $line.','."\n";
		}
		else
		{
			$tmp .= $line."\n";
		}
	}


	$tmp .= '); -- ".$sql_tag."\n";'."\n";
	$tmp .= "\n";
	$tmp .= "\n";
	$tmp .= '	$sql_result = libsql__query($sql_handle, $sql_tag, $sql_str, $result);'."\n";
	$tmp .= '	if ($sql_result === false)'."\n";
	$tmp .= '	{'."\n";
	$tmp .= '		$result->set_err(1, "sql error", libsql__error($sql_handle));'."\n";
	$tmp .= '		return $result;'."\n";
	$tmp .= '	}'."\n";
	$tmp .= '/*'."\n";
	$tmp .= '	if (libsql__num_rows($sql_result) !== 0)'."\n";
	$tmp .= '	{'."\n";
	$tmp .= '		$row = @pg_fetch_array($sql_result);'."\n";
	$tmp .= ''."\n";
	$tmp .= '		$item                = new pongo_overlord__key_meta_t;'."\n";
	$tmp .= ''."\n";
	$tmp .= '		$item->id            = $row["id"];'."\n";
	$tmp .= '		$item->collection_id = $row["collection_id"];'."\n";
	$tmp .= '		$item->role_id       = $row["role_id"];'."\n";
	$tmp .= '		$item->role_rid      = $row["role_rid"];'."\n";
	$tmp .= '		$item->server_id     = $row["server_id"];'."\n";
	$tmp .= '		$item->ctime         = $row["ctime"];'."\n";
	$tmp .= '		$item->mtime         = $row["mtime"];'."\n";
	$tmp .= '		$item->flag_enable   = $row["flag_enable"];'."\n";
	$tmp .= '		$item->flag_valid    = $row["flag_valid"];'."\n";
	$tmp .= '	}'."\n";
	$tmp .= '*/'."\n";
	$tmp .= '	libsql__query_free($sql_result);'."\n";
	$tmp .= ''."\n";
	$tmp .= ''."\n";
	$tmp .= '	$result->set_ok();'."\n";
	$tmp .= '//	$result->set_value($item);'."\n";
	$tmp .= '	return $result;'."\n";
	$tmp .= '}'."\n";
	$tmp .= make_line();


	$filename = $target_dir.'/'.$server_name.'/'.$table_schema.'.'.$table_name.'/add/auto/'.$plan->name.'.php';
//echo '['.$filename.']'."\n";
	$rc = libcore__file_set($filename, $tmp);
	if ($rc === false)
	{
		$result->set_err(1, 'can not save file');
		return $result;
	}


	$result->set_ok();
	return $result;
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function generate_update($arg, $plan)
{
	$result = new result_t(__FUNCTION__, __FILE__);


	$target_dir         = $arg->target_dir;
	$server_name        = $arg->server_name;
	$table_schema       = $arg->table_schema;
	$table_name         = $arg->table_name;
	$table_columns_list = $arg->table_columns_list;
	$table_name_short   = $arg->table_name_short;
	$model_name         = $arg->model_name;


	$table_columns_list_size = count($table_columns_list);
	$filter_size = count($plan->filter);


	$max_name_size = 0;
	for ($i=0; $i < $filter_size; $i++)
	{
		$name_size = strlen($plan->filter[$i]);
		if ($name_size > $max_name_size)
		{
			$max_name_size = $name_size;
		}
	}
	$max_name_size++;


	$tmp  = make_line();
	$tmp .= '// PLEASE DO NOT EDIT IT !!! THIS FILE IS GENERATED BY https://github.com/progman/reverse_orm.php'."\n";
	$tmp .= make_line();
	$tmp .= 'function sql_orm_set__'.$table_schema.'__'.$table_name.'__'.$plan->name.'($sql_handle, $obj, $filter_list, $sort_list, $offset, $limit, $flag_lock = false)'."\n";
	$tmp .= '{'."\n";
	$tmp .= '	$result = new result_t(__FUNCTION__, __FILE__);'."\n";
	$tmp .= '//	$item = null;'."\n";
	$tmp .= ''."\n";
	$tmp .= ''."\n";
	$tmp .= '	$sql_tag = "SQLXXX".__FUNCTION__;'."\n";
	$tmp .= '	$sql_str = "'."\n";
	$tmp .= 'UPDATE '.$table_schema.'.'.$table_name.' AS '.$table_name_short."\n";
	$tmp .= 'SET'."\n";


	for ($i=0; $i < $table_columns_list_size; $i++)
	{
		$line = '';
		$flag_found = false;
		for (;;)
		{
			if (strcmp($table_columns_list[$i]->data_type_real, 'bytea') === 0)
			{
				$line .= '		'.$table_columns_list[$i]->column_name.spacer1($table_columns_list, $i).'= ".libsql__var2bytea      ($obj->'.$table_columns_list[$i]->column_name.')."';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'bytea[]') === 0)
			{
				$line .= '		'.$table_columns_list[$i]->column_name.spacer1($table_columns_list, $i).'= ".libsql__var2bytea_list ($obj->'.$table_columns_list[$i]->column_name.')."';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'text') === 0)
			{
				$line .= '		'.$table_columns_list[$i]->column_name.spacer1($table_columns_list, $i).'= ".libsql__var2text       ($obj->'.$table_columns_list[$i]->column_name.')."';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'text[]') === 0)
			{
				$line .= '		'.$table_columns_list[$i]->column_name.spacer1($table_columns_list, $i).'= ".libsql__var2text_list  ($obj->'.$table_columns_list[$i]->column_name.')."';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'json') === 0)
			{
				$line .= '		'.$table_columns_list[$i]->column_name.spacer1($table_columns_list, $i).'= ".libsql__var2json       ($obj->'.$table_columns_list[$i]->column_name.')."';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'json[]') === 0)
			{
				$line .= '		'.$table_columns_list[$i]->column_name.spacer1($table_columns_list, $i).'= ".libsql__var2json_list  ($obj->'.$table_columns_list[$i]->column_name.')."';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'bigint') === 0)
			{
				$line .= '		'.$table_columns_list[$i]->column_name.spacer1($table_columns_list, $i).'= ".libsql__var2bigint     ($obj->'.$table_columns_list[$i]->column_name.')."';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'bigint[]') === 0)
			{
				$line .= '		'.$table_columns_list[$i]->column_name.spacer1($table_columns_list, $i).'= ".libsql__var2bigint_list($obj->'.$table_columns_list[$i]->column_name.')."';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'timestamp') === 0)
			{
				$line .= '		'.$table_columns_list[$i]->column_name.spacer1($table_columns_list, $i).'= ".libsql__var2time       ($obj->'.$table_columns_list[$i]->column_name.')."';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'timestamp[]') === 0)
			{
				$line .= '		'.$table_columns_list[$i]->column_name.spacer1($table_columns_list, $i).'= ".libsql__var2time_list  ($obj->'.$table_columns_list[$i]->column_name.')."';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'boolean') === 0)
			{
				$line .= '		'.$table_columns_list[$i]->column_name.spacer1($table_columns_list, $i).'= ".libsql__var2bool       ($obj->'.$table_columns_list[$i]->column_name.')."';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'boolean[]') === 0)
			{
				$line .= '		'.$table_columns_list[$i]->column_name.spacer1($table_columns_list, $i).'= ".libsql__var2bool_list  ($obj->'.$table_columns_list[$i]->column_name.')."';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'uuid') === 0)
			{
				$line .= '		'.$table_columns_list[$i]->column_name.spacer1($table_columns_list, $i).'= ".libsql__var2uuid       ($obj->'.$table_columns_list[$i]->column_name.')."';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'uuid[]') === 0)
			{
				$line .= '		'.$table_columns_list[$i]->column_name.spacer1($table_columns_list, $i).'= ".libsql__var2uuid_list  ($obj->'.$table_columns_list[$i]->column_name.')."';
				$flag_found = true;
				break;
			}

			break;
		}
		if ($flag_found === false)
		{
			$result->set_err(1, 'data_type "'.$table_columns_list[$i]->data_type_real.'" is unknown');
			return $result;
		}


		if (($i + 1) !== $table_columns_list_size)
		{
			$tmp .= $line.','."\n";
		}
		else
		{
			$tmp .= $line."\n";
		}
	}


	if ($filter_size === 0)
	{
		$tmp .= '";'."\n";
	}
	else
	{
		$tmp .= 'WHERE'."\n";
	}


	for ($i=0; $i < $filter_size; $i++)
	{
		$data_type_real = null;
		$flag_found = false;
		for ($j=0; $j < $table_columns_list_size; $j++)
		{
			if (strcmp($table_columns_list[$j]->column_name, $plan->filter[$i]) === 0)
			{
				$flag_found = true;
				$data_type_real = $table_columns_list[$j]->data_type_real;
			}
		}
		if ($flag_found === false)
		{
			$result->set_err(1, 'column name "'.$plan->filter[$i].'" from filter was not found in table');
			return $result;
		}


		$shift = '		';
		if ($filter_size !== 1)
		{
			$shift = '			';
		}
		if ($i !== 0)
		{
			$shift = '		AND ';
		}


		$line = '';
		$flag_found = false;
		for (;;)
		{
			if (strcmp($data_type_real, 'bytea') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2bytea      ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'bytea[]') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2bytea_list ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'text') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2text       ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'text[]') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2text_list  ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'json') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2json       ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'json[]') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2json_list  ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'bigint') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2bigint     ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'bigint[]') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2bigint_list($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'timestamp') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2time       ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'timestamp[]') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2time_list  ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'boolean') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2bool       ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'boolean[]') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2bool_list  ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'uuid') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2uuid       ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'uuid[]') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2uuid_list  ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			break;
		}
		if ($flag_found === false)
		{
			$result->set_err(1, 'data_type "'.$table_columns_list[$i]->data_type_real.'" is unknown (002)');
			return $result;
		}
		$tmp .= $line."\n";
	}


	if ($filter_size !== 0)
	{
		$tmp .= "\";\n";
	}


	$tmp .= "\n";
	$tmp .= '	$sql_str .= "; -- ".$sql_tag."\n";'."\n";


	$tmp .= "\n";
	$tmp .= "\n";
	$tmp .= '	$sql_result = libsql__query($sql_handle, $sql_tag, $sql_str, $result);'."\n";
	$tmp .= '	if ($sql_result === false)'."\n";
	$tmp .= '	{'."\n";
	$tmp .= '		$result->set_err(1, "sql error", libsql__error($sql_handle));'."\n";
	$tmp .= '		return $result;'."\n";
	$tmp .= '	}'."\n";
	$tmp .= '/*'."\n";
	$tmp .= '	if (libsql__num_rows($sql_result) != 0)'."\n";
	$tmp .= '	{'."\n";
	$tmp .= '		$row = @pg_fetch_array($sql_result);'."\n";
	$tmp .= ''."\n";
	$tmp .= '		$item                = new pongo_overlord__key_meta_t;'."\n";
	$tmp .= ''."\n";
	$tmp .= '		$item->id            = $row["id"];'."\n";
	$tmp .= '		$item->collection_id = $row["collection_id"];'."\n";
	$tmp .= '		$item->role_id       = $row["role_id"];'."\n";
	$tmp .= '		$item->role_rid      = $row["role_rid"];'."\n";
	$tmp .= '		$item->server_id     = $row["server_id"];'."\n";
	$tmp .= '		$item->ctime         = $row["ctime"];'."\n";
	$tmp .= '		$item->mtime         = $row["mtime"];'."\n";
	$tmp .= '		$item->flag_enable   = $row["flag_enable"];'."\n";
	$tmp .= '		$item->flag_valid    = $row["flag_valid"];'."\n";
	$tmp .= '	}'."\n";
	$tmp .= '*/'."\n";
	$tmp .= '	libsql__query_free($sql_result);'."\n";
	$tmp .= ''."\n";
	$tmp .= ''."\n";
	$tmp .= '	$result->set_ok();'."\n";
	$tmp .= '//	$result->set_value($item);'."\n";
	$tmp .= '	return $result;'."\n";
	$tmp .= '}'."\n";
	$tmp .= make_line();


	$filename = $target_dir.'/'.$server_name.'/'.$table_schema.'.'.$table_name.'/set/auto/'.$plan->name.'.php';
//echo '['.$filename.']'."\n";
	$rc = libcore__file_set($filename, $tmp);
	if ($rc === false)
	{
		$result->set_err(1, 'can not save file');
		return $result;
	}


	$result->set_ok();
	return $result;
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function generate_select_count($arg, $plan)
{
	$result = new result_t(__FUNCTION__, __FILE__);


	$target_dir         = $arg->target_dir;
	$server_name        = $arg->server_name;
	$table_schema       = $arg->table_schema;
	$table_name         = $arg->table_name;
	$table_columns_list = $arg->table_columns_list;
	$table_name_short   = $arg->table_name_short;
	$model_name         = $arg->model_name;


	$table_columns_list_size = count($table_columns_list);
	$filter_size = count($plan->filter);


	$max_name_size = 0;
	for ($i=0; $i < $filter_size; $i++)
	{
		$name_size = strlen($plan->filter[$i]);
		if ($name_size > $max_name_size)
		{
			$max_name_size = $name_size;
		}
	}
	$max_name_size++;


	$tmp  = make_line();
	$tmp .= '// PLEASE DO NOT EDIT IT !!! THIS FILE IS GENERATED BY https://github.com/progman/reverse_orm.php'."\n";
	$tmp .= make_line();
	$tmp .= 'function sql_orm_cnt__'.$table_schema.'__'.$table_name.'__'.$plan->name.'($sql_handle, $obj, $filter_list, $sort_list, $offset, $limit, $flag_lock = false)'."\n";
	$tmp .= '{'."\n";
	$tmp .= '	$result = new result_t(__FUNCTION__, __FILE__);'."\n";
	$tmp .= '	$item = 0;'."\n";
	$tmp .= ''."\n";
	$tmp .= ''."\n";
	$tmp .= '	$sql_tag = "SQLXXX".__FUNCTION__;'."\n";
	$tmp .= '	$sql_str = "'."\n";
	$tmp .= 'SELECT'."\n";
	$tmp .= '		COUNT('.$table_name_short.'.id) AS value'."\n";
	$tmp .= 'FROM'."\n";
	$tmp .= '		'.$table_schema.'.'.$table_name.' AS '.$table_name_short."\n";


	if ($filter_size === 0)
	{
		$tmp .= '";'."\n";
	}
	else
	{
		$tmp .= 'WHERE'."\n";
	}


	for ($i=0; $i < $filter_size; $i++)
	{
		$data_type_real = null;
		$flag_found = false;
		for ($j=0; $j < $table_columns_list_size; $j++)
		{
			if (strcmp($table_columns_list[$j]->column_name, $plan->filter[$i]) === 0)
			{
				$flag_found = true;
				$data_type_real = $table_columns_list[$j]->data_type_real;
			}
		}
		if ($flag_found === false)
		{
			$result->set_err(1, 'column name "'.$plan->filter[$i].'" from filter was not found in table');
			return $result;
		}


		$shift = '		';
		if ($filter_size !== 1)
		{
			$shift = '			';
		}
		if ($i !== 0)
		{
			$shift = '		AND ';
		}


		$line = '';
		$flag_found = false;
		for (;;)
		{
			if (strcmp($data_type_real, 'bytea') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2bytea      ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'bytea[]') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2bytea_list ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'text') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2text       ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'text[]') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2text_list  ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'json') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2json       ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'json[]') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2json_list  ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'bigint') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2bigint     ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'bigint[]') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2bigint_list($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'timestamp') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2time       ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'timestamp[]') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2time_list  ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'boolean') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2bool       ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'boolean[]') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2bool_list  ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'uuid') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2uuid       ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'uuid[]') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2uuid_list  ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			break;
		}
		if ($flag_found === false)
		{
			$result->set_err(1, 'data_type "'.$table_columns_list[$i]->data_type_real.'" is unknown (002)');
			return $result;
		}
		$tmp .= $line."\n";
	}


	if ($filter_size !== 0)
	{
		$tmp .= "\";\n";
	}


	$tmp .= "\n";
	$tmp .= '	$sql_str .= "; -- ".$sql_tag."\n";'."\n";


	$tmp .= ''."\n";
	$tmp .= ''."\n";
	$tmp .= '	$sql_result = libsql__query($sql_handle, $sql_tag, $sql_str, $result);'."\n";
	$tmp .= '	if ($sql_result === false)'."\n";
	$tmp .= '	{'."\n";
	$tmp .= '		$result->set_err(1, "sql error", libsql__error($sql_handle));'."\n";
	$tmp .= '		return $result;'."\n";
	$tmp .= '	}'."\n";
	$tmp .= ''."\n";
	$tmp .= '	if (libsql__num_rows($sql_result) !== 0)'."\n";
	$tmp .= '	{'."\n";
	$tmp .= '		$row = @pg_fetch_array($sql_result);'."\n";
	$tmp .= ''."\n";
	$tmp .= '		$item = $row["value"];'."\n";
	$tmp .= ''."\n";
	$tmp .= '		settype($item, "integer");'."\n";
	$tmp .= '	}'."\n";
	$tmp .= '	libsql__query_free($sql_result);'."\n";

	$tmp .= ''."\n";
	$tmp .= ''."\n";
	$tmp .= '	$result->set_ok();'."\n";
	$tmp .= '	$result->set_value($item);'."\n";
	$tmp .= '	return $result;'."\n";
	$tmp .= '}'."\n";
	$tmp .= make_line();


	$filename = $target_dir.'/'.$server_name.'/'.$table_schema.'.'.$table_name.'/cnt/auto/'.$plan->name.'.php';
//echo '['.$filename.']'."\n";
	$rc = libcore__file_set($filename, $tmp);
	if ($rc === false)
	{
		$result->set_err(1, 'can not save file');
		return $result;
	}


	$result->set_ok();
	return $result;
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function generate_select_list($arg, $plan)
{
	$result = new result_t(__FUNCTION__, __FILE__);


	$target_dir         = $arg->target_dir;
	$server_name        = $arg->server_name;
	$table_schema       = $arg->table_schema;
	$table_name         = $arg->table_name;
	$table_columns_list = $arg->table_columns_list;
	$table_name_short   = $arg->table_name_short;
	$model_name         = $arg->model_name;


	$table_columns_list_size = count($table_columns_list);
	$filter_size = count($plan->filter);


	$max_name_size = 0;
	for ($i=0; $i < $filter_size; $i++)
	{
		$name_size = strlen($plan->filter[$i]);
		if ($name_size > $max_name_size)
		{
			$max_name_size = $name_size;
		}
	}
	$max_name_size++;


	$tmp  = make_line();
	$tmp .= '// PLEASE DO NOT EDIT IT !!! THIS FILE IS GENERATED BY https://github.com/progman/reverse_orm.php'."\n";
	$tmp .= make_line();
	$tmp .= 'function sql_orm_get__'.$table_schema.'__'.$table_name.'__'.$plan->name.'($sql_handle, $obj, $filter_list, $sort_list, $offset, $limit, $flag_lock = false)'."\n";
	$tmp .= '{'."\n";
	$tmp .= '	$result = new result_t(__FUNCTION__, __FILE__);'."\n";
	$tmp .= '	$item_list = array();'."\n";
	$tmp .= ''."\n";
	$tmp .= ''."\n";
	$tmp .= '	$sql_tag = "SQLXXX".__FUNCTION__;'."\n";
	$tmp .= '	$sql_str = "'."\n";
	$tmp .= 'SELECT'."\n";


	for ($i=0; $i < $table_columns_list_size; $i++)
	{
		$line = '';
		$flag_found = false;
		for (;;)
		{
			if (strcmp($table_columns_list[$i]->data_type_real, 'bytea') === 0)
			{
				$line .= '		".libsql__bytea2var      ("'.$table_name_short.'", "'.$table_columns_list[$i]->column_name.'")."';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'bytea[]') === 0)
			{
				$line .= '		".libsql__bytea2var_list ("'.$table_name_short.'", "'.$table_columns_list[$i]->column_name.'")."';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'text') === 0)
			{
				$line .= '		".libsql__text2var       ("'.$table_name_short.'", "'.$table_columns_list[$i]->column_name.'")."';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'text[]') === 0)
			{
				$line .= '		".libsql__text2var_list  ("'.$table_name_short.'", "'.$table_columns_list[$i]->column_name.'")."';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'json') === 0)
			{
				$line .= '		".libsql__json2var       ("'.$table_name_short.'", "'.$table_columns_list[$i]->column_name.'")."';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'json[]') === 0)
			{
				$line .= '		".libsql__json2var_list  ("'.$table_name_short.'", "'.$table_columns_list[$i]->column_name.'")."';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'bigint') === 0)
			{
				$line .= '		".libsql__bigint2var     ("'.$table_name_short.'", "'.$table_columns_list[$i]->column_name.'")."';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'bigint[]') === 0)
			{
				$line .= '		".libsql__bigint2var_list("'.$table_name_short.'", "'.$table_columns_list[$i]->column_name.'")."';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'timestamp') === 0)
			{
				$line .= '		".libsql__time2var       ("'.$table_name_short.'", "'.$table_columns_list[$i]->column_name.'")."';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'timestamp[]') === 0)
			{
				$line .= '		".libsql__time2var_list  ("'.$table_name_short.'", "'.$table_columns_list[$i]->column_name.'")."';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'boolean') === 0)
			{
				$line .= '		".libsql__flag2var       ("'.$table_name_short.'", "'.$table_columns_list[$i]->column_name.'")."';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'boolean[]') === 0)
			{
				$line .= '		".libsql__flag2var_list  ("'.$table_name_short.'", "'.$table_columns_list[$i]->column_name.'")."';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'uuid') === 0)
			{
				$line .= '		".libsql__uuid2var       ("'.$table_name_short.'", "'.$table_columns_list[$i]->column_name.'")."';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'uuid[]') === 0)
			{
				$line .= '		".libsql__uuid2var_list  ("'.$table_name_short.'", "'.$table_columns_list[$i]->column_name.'")."';
				$flag_found = true;
				break;
			}

			break;
		}
		if ($flag_found === false)
		{
			$result->set_err(1, 'data_type "'.$table_columns_list[$i]->data_type_real.'" is unknown');
			return $result;
		}


		if (($i + 1) !== $table_columns_list_size)
		{
			$tmp .= $line.','."\n";
		}
		else
		{
			$tmp .= $line."\n";
		}
	}


	$tmp .= 'FROM'."\n";
	$tmp .= '		'.$table_schema.'.'.$table_name.' AS '.$table_name_short."\n";


	if ($filter_size === 0)
	{
		$tmp .= '";'."\n";
	}
	else
	{
		$tmp .= 'WHERE'."\n";
	}


	for ($i=0; $i < $filter_size; $i++)
	{
		$data_type_real = null;
		$flag_found = false;
		for ($j=0; $j < $table_columns_list_size; $j++)
		{
			if (strcmp($table_columns_list[$j]->column_name, $plan->filter[$i]) === 0)
			{
				$flag_found = true;
				$data_type_real = $table_columns_list[$j]->data_type_real;
			}
		}
		if ($flag_found === false)
		{
			$result->set_err(1, 'column name "'.$plan->filter[$i].'" from filter was not found in table');
			return $result;
		}


		$shift = '		';
		if ($filter_size !== 1)
		{
			$shift = '			';
		}
		if ($i !== 0)
		{
			$shift = '		AND ';
		}


		$line = '';
		$flag_found = false;
		for (;;)
		{
			if (strcmp($data_type_real, 'bytea') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2bytea      ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'bytea[]') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2bytea_list ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'text') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2text       ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'text[]') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2text_list  ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'json') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2json       ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'json[]') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2json_list  ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'bigint') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2bigint     ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'bigint[]') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2bigint_list($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'timestamp') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2time       ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'timestamp[]') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2time_list  ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'boolean') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2bool       ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'boolean[]') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2bool_list  ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'uuid') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2uuid       ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'uuid[]') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2uuid_list  ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			break;
		}
		if ($flag_found === false)
		{
			$result->set_err(1, 'data_type "'.$table_columns_list[$i]->data_type_real.'" is unknown (002)');
			return $result;
		}
		$tmp .= $line."\n";
	}


	if ($filter_size !== 0)
	{
		$tmp .= "\";\n";
	}


//ORDER BY rt.ctime DESC
//ORDER BY cc.ctime DESC
//	$tmp .= 'ORDER BY '.$table_name_short.'.ctime DESC'."\n";


	$sort_size = 0;
	foreach ($plan->sort as $key => $value)
	{
		$sort_size++;
	}


	if ($sort_size !== 0)
	{
		$tmp .= '	$sql_str .= "ORDER BY ';

		$i=0;
		foreach ($plan->sort as $key => $value)
		{
			if ($i != 0)
			{
				$tmp .= ', ';
			}

			$tmp .= $key.' '.$value;

			$i++;
		}

		$tmp .= '\n";'."\n";
	}


	$tmp .= "\n";
	$tmp .= '	if (($offset !== null) && ($limit !== null))'."\n";
	$tmp .= '	{'."\n";
	$tmp .= '		$sql_str .= "OFFSET ".libsql__var2bigint($offset)."'."\\n\";\n";
	$tmp .= '		$sql_str .= "LIMIT ".libsql__var2bigint($limit)."'."\\n\";\n";
	$tmp .= '	}'."\n";


	$tmp .= "\n";


	$tmp .= '	if ($flag_lock !== false)'."\n";
	$tmp .= '	{'."\n";
	$tmp .= '		$sql_str .= "FOR UPDATE";'."\n";
	$tmp .= '	}'."\n";
	$tmp .= '	$sql_str .= "; -- ".$sql_tag."\n";'."\n";


	$tmp .= "\n";
	$tmp .= "\n";
	$tmp .= '	$sql_result = libsql__query($sql_handle, $sql_tag, $sql_str, $result);'."\n";
	$tmp .= '	if ($sql_result === false)'."\n";
	$tmp .= '	{'."\n";
	$tmp .= '		$result->set_err(1, "sql error", libsql__error($sql_handle));'."\n";
	$tmp .= '		return $result;'."\n";
	$tmp .= '	}'."\n";
	$tmp .= ''."\n";
	$tmp .= '	if (libsql__num_rows($sql_result) !== 0)'."\n";
	$tmp .= '	{'."\n";
	$tmp .= '		while ($row = @pg_fetch_array($sql_result))'."\n";
	$tmp .= '		{'."\n";
//	$tmp .= '			$item = new '.$model_name.';'."\n";
	$tmp .= '			$item = new stdClass();'."\n";
	$tmp .= "\n";


	for ($i=0; $i < $table_columns_list_size; $i++)
	{
		$line = '';
		$flag_found = false;
		for (;;)
		{
			if (strcmp($table_columns_list[$i]->data_type_real, 'bytea') === 0)
			{
				$line .= '			$item->'.$table_columns_list[$i]->column_name.spacer1($table_columns_list, $i).'= $row["'.$table_columns_list[$i]->column_name.'"];';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'bytea[]') === 0)
			{
				$line .= '			$item->'.$table_columns_list[$i]->column_name.spacer1($table_columns_list, $i).'= $row["'.$table_columns_list[$i]->column_name.'"];';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'text') === 0)
			{
				$line .= '			$item->'.$table_columns_list[$i]->column_name.spacer1($table_columns_list, $i).'= $row["'.$table_columns_list[$i]->column_name.'"];';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'text[]') === 0)
			{
				$line .= '			$item->'.$table_columns_list[$i]->column_name.spacer1($table_columns_list, $i).'= $row["'.$table_columns_list[$i]->column_name.'"];';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'json') === 0)
			{
				$line .= '			$item->'.$table_columns_list[$i]->column_name.spacer1($table_columns_list, $i).'= json_decode($row["'.$table_columns_list[$i]->column_name.'"]);';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'json[]') === 0)
			{
				$line .= '			$item->'.$table_columns_list[$i]->column_name.spacer1($table_columns_list, $i).'= json_decode($row["'.$table_columns_list[$i]->column_name.'"]);';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'bigint') === 0)
			{
				$line .= '			$item->'.$table_columns_list[$i]->column_name.spacer1($table_columns_list, $i).'= $row["'.$table_columns_list[$i]->column_name.'"];';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'bigint[]') === 0)
			{
				$line .= '			$item->'.$table_columns_list[$i]->column_name.spacer1($table_columns_list, $i).'= $row["'.$table_columns_list[$i]->column_name.'"];';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'timestamp') === 0)
			{
				$line .= '			$item->'.$table_columns_list[$i]->column_name.spacer1($table_columns_list, $i).'= $row["'.$table_columns_list[$i]->column_name.'"];';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'timestamp[]') === 0)
			{
				$line .= '			$item->'.$table_columns_list[$i]->column_name.spacer1($table_columns_list, $i).'= $row["'.$table_columns_list[$i]->column_name.'"];';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'boolean') === 0)
			{
				$line .= '			$item->'.$table_columns_list[$i]->column_name.spacer1($table_columns_list, $i).'= $row["'.$table_columns_list[$i]->column_name.'"];';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'boolean[]') === 0)
			{
				$line .= '			$item->'.$table_columns_list[$i]->column_name.spacer1($table_columns_list, $i).'= $row["'.$table_columns_list[$i]->column_name.'"];';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'uuid') === 0)
			{
				$line .= '			$item->'.$table_columns_list[$i]->column_name.spacer1($table_columns_list, $i).'= $row["'.$table_columns_list[$i]->column_name.'"];';
				$flag_found = true;
				break;
			}

			if (strcmp($table_columns_list[$i]->data_type_real, 'uuid[]') === 0)
			{
				$line .= '			$item->'.$table_columns_list[$i]->column_name.spacer1($table_columns_list, $i).'= $row["'.$table_columns_list[$i]->column_name.'"];';
				$flag_found = true;
				break;
			}

			break;
		}
		if ($flag_found === false)
		{
			$result->set_err(1, 'data_type "'.$table_columns_list[$i]->data_type_real.'" is unknown');
			return $result;
		}
		$tmp .= $line."\n";
	}


	$tmp .= ''."\n";
	$tmp .= '			array_push($item_list, $item);'."\n";
	$tmp .= '		}'."\n";
	$tmp .= '	}'."\n";
	$tmp .= '	libsql__query_free($sql_result);'."\n";
	$tmp .= ''."\n";
	$tmp .= ''."\n";
	$tmp .= '	$result->set_ok();'."\n";
	$tmp .= '	$result->set_value($item_list);'."\n";
	$tmp .= '	return $result;'."\n";
	$tmp .= '}'."\n";
	$tmp .= make_line();


	$filename = $target_dir.'/'.$server_name.'/'.$table_schema.'.'.$table_name.'/get/auto/'.$plan->name.'.php';
//echo '['.$filename.']'."\n";
	$rc = libcore__file_set($filename, $tmp);
	if ($rc === false)
	{
		$result->set_err(1, 'can not save file');
		return $result;
	}


	$result->set_ok();
	return $result;
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function generate_delete($arg, $plan)
{
	$result = new result_t(__FUNCTION__, __FILE__);


	$target_dir         = $arg->target_dir;
	$server_name        = $arg->server_name;
	$table_schema       = $arg->table_schema;
	$table_name         = $arg->table_name;
	$table_columns_list = $arg->table_columns_list;
	$table_name_short   = $arg->table_name_short;
	$model_name         = $arg->model_name;


	$table_columns_list_size = count($table_columns_list);
	$filter_size = count($plan->filter);


	$max_name_size = 0;
	for ($i=0; $i < $filter_size; $i++)
	{
		$name_size = strlen($plan->filter[$i]);
		if ($name_size > $max_name_size)
		{
			$max_name_size = $name_size;
		}
	}
	$max_name_size++;


//	print_r($table_columns_list);


	$tmp  = make_line();
	$tmp .= '// PLEASE DO NOT EDIT IT !!! THIS FILE IS GENERATED BY https://github.com/progman/reverse_orm.php'."\n";
	$tmp .= make_line();
	$tmp .= 'function sql_orm_del__'.$table_schema.'__'.$table_name.'__'.$plan->name.'($sql_handle, $obj, $filter_list, $sort_list, $offset, $limit, $flag_lock = false)'."\n";
	$tmp .= '{'."\n";
	$tmp .= '	$result = new result_t(__FUNCTION__, __FILE__);'."\n";
	$tmp .= '//	$item = null;'."\n";
	$tmp .= ''."\n";
	$tmp .= ''."\n";
	$tmp .= '	$sql_tag = "SQLXXX".__FUNCTION__;'."\n";
	$tmp .= '	$sql_str = "'."\n";
	$tmp .= 'DELETE FROM '.$table_schema.'.'.$table_name.' AS '.$table_name_short."\n";

/*
	$tmp .= '";'."\n";


	if ($filter_size !== 0)
	{
		$tmp .= "\n";
		$tmp .= '	$sql_str .= "'."\n";
		$tmp .= 'WHERE'."\n";
	}
*/

	if ($filter_size === 0)
	{
		$tmp .= '";'."\n";
	}
	else
	{
		$tmp .= 'WHERE'."\n";
	}


	for ($i=0; $i < $filter_size; $i++)
	{
		$data_type_real = null;
		$flag_found = false;
		for ($j=0; $j < $table_columns_list_size; $j++)
		{
			if (strcmp($table_columns_list[$j]->column_name, $plan->filter[$i]) === 0)
			{
				$flag_found = true;
				$data_type_real = $table_columns_list[$j]->data_type_real;
			}
		}
		if ($flag_found === false)
		{
			$result->set_err(1, 'column name "'.$plan->filter[$i].'" from filter was not found in table');
			return $result;
		}


		$shift = '		';
		if ($filter_size !== 1)
		{
			$shift = '			';
		}
		if ($i !== 0)
		{
			$shift = '		AND ';
		}


		$line = '';
		$flag_found = false;
		for (;;)
		{
			if (strcmp($data_type_real, 'bytea') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2bytea      ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'bytea[]') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2bytea_list ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'text') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2text       ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'text[]') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2text_list  ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'json') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2json       ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'json[]') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2json_list  ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'bigint') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2bigint     ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'bigint[]') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2bigint_list($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'timestamp') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2time       ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'timestamp[]') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2time_list  ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'boolean') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2bool       ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'boolean[]') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2bool_list  ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'uuid') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2uuid       ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			if (strcmp($data_type_real, 'uuid[]') === 0)
			{
				$line .= $shift.$table_name_short.'.'.$plan->filter[$i].spacer2($plan->filter[$i], $max_name_size).'= ".libsql__var2uuid_list  ($filter_list->'.$plan->filter[$i].')."';
				$flag_found = true;
				break;
			}

			break;
		}
		if ($flag_found === false)
		{
			$result->set_err(1, 'data_type "'.$table_columns_list[$i]->data_type_real.'" is unknown (002)');
			return $result;
		}
		$tmp .= $line."\n";
	}


	if ($filter_size !== 0)
	{
		$tmp .= "\";\n";
	}


	$tmp .= "\n";
	$tmp .= '	$sql_str .= "; -- ".$sql_tag."\n";'."\n";


	$tmp .= "\n";
	$tmp .= "\n";
	$tmp .= '	$sql_result = libsql__query($sql_handle, $sql_tag, $sql_str, $result);'."\n";
	$tmp .= '	if ($sql_result === false)'."\n";
	$tmp .= '	{'."\n";
	$tmp .= '		$result->set_err(1, "sql error", libsql__error($sql_handle));'."\n";
	$tmp .= '		return $result;'."\n";
	$tmp .= '	}'."\n";
	$tmp .= '/*'."\n";
	$tmp .= '	if (libsql__num_rows($sql_result) != 0)'."\n";
	$tmp .= '	{'."\n";
	$tmp .= '		$row = @pg_fetch_array($sql_result);'."\n";
	$tmp .= ''."\n";
	$tmp .= '		$item                = new pongo_overlord__key_meta_t;'."\n";
	$tmp .= ''."\n";
	$tmp .= '		$item->id            = $row["id"];'."\n";
	$tmp .= '		$item->collection_id = $row["collection_id"];'."\n";
	$tmp .= '		$item->role_id       = $row["role_id"];'."\n";
	$tmp .= '		$item->role_rid      = $row["role_rid"];'."\n";
	$tmp .= '		$item->server_id     = $row["server_id"];'."\n";
	$tmp .= '		$item->ctime         = $row["ctime"];'."\n";
	$tmp .= '		$item->mtime         = $row["mtime"];'."\n";
	$tmp .= '		$item->flag_enable   = $row["flag_enable"];'."\n";
	$tmp .= '		$item->flag_valid    = $row["flag_valid"];'."\n";
	$tmp .= '	}'."\n";
	$tmp .= '*/'."\n";
	$tmp .= '	libsql__query_free($sql_result);'."\n";
	$tmp .= ''."\n";
	$tmp .= ''."\n";
	$tmp .= '	$result->set_ok();'."\n";
	$tmp .= '//	$result->set_value($item);'."\n";
	$tmp .= '	return $result;'."\n";
	$tmp .= '}'."\n";
	$tmp .= make_line();


	$filename = $target_dir.'/'.$server_name.'/'.$table_schema.'.'.$table_name.'/del/auto/'.$plan->name.'.php';
//echo '['.$filename.']'."\n";
	$rc = libcore__file_set($filename, $tmp);
	if ($rc === false)
	{
		$result->set_err(1, 'can not save file');
		return $result;
	}


	$result->set_ok();
	return $result;
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function generate_example($arg)
{
	$result = new result_t(__FUNCTION__, __FILE__);


	$target_dir         = $arg->target_dir;
	$server_name        = $arg->server_name;
	$table_schema       = $arg->table_schema;
	$table_name         = $arg->table_name;
	$table_columns_list = $arg->table_columns_list;
	$table_name_short   = $arg->table_name_short;
	$model_name         = $arg->model_name;


	$table_columns_list_size = count($table_columns_list);
//	$plan_list_size = count($plan_list);



	$tmp  = '';

	$tmp .= "/*"."\n";


	$tmp .= "// init model ".$table_name."\n";
	$tmp .= "	\$".$table_schema."__".$table_name." = new ".$table_schema."__".$table_name."__t(\$sql_handle);\n";
	$tmp .= "\n";
	$tmp .= "\n";


	$max_col_name_size = 0;
	for ($i=0; $i < $table_columns_list_size; $i++)
	{
		$size = strlen($table_columns_list[$i]->column_name);

		if ($size > $max_col_name_size)
		{
			$max_col_name_size = $size;
		}
	}
	$max_col_name_size++;


	$max_col_type_size = 0;
	for ($i=0; $i < $table_columns_list_size; $i++)
	{
		$line = $table_columns_list[$i]->data_type_real;
		$size = strlen($line);


		if ($size > $max_col_type_size)
		{
			$max_col_type_size = $size;
		}
	}
	$max_col_type_size++;


	$tmp .= "// add ".$table_name."\n";
	for ($i=0; $i < $table_columns_list_size; $i++)
	{
		$tmp .= "	\$".$table_schema."__".$table_name."->".$table_columns_list[$i]->column_name;


		$size = $max_col_name_size - strlen($table_columns_list[$i]->column_name);


		for ($j=0; $j < $size; $j++)
		{
			$tmp .= " ";
		}
		$tmp .= "= null; // ";
		$tmp .= $table_columns_list[$i]->column_name;


		for ($j=0; $j < $size; $j++)
		{
			$tmp .= " ";
		}
		$tmp .= "| ";


		$line = $table_columns_list[$i]->data_type_real;
		$size = $max_col_type_size - strlen($line);


		$tmp .= $line;
		for ($j=0; $j < $size; $j++)
		{
			$tmp .= " ";
		}
		$tmp .= "| ";


		if (strcmp($table_columns_list[$i]->is_nullable, "NO") === 0)
		{
			$tmp .= "NOT NULL |";
		}
		else
		{
			$tmp .= "    NULL |";
		}


		if (isset($table_columns_list[$i]->column_comment) !== false)
		{
			$tmp .= " ";
			$tmp .= $table_columns_list[$i]->column_comment;
		}


		$tmp .= "\n";
	}


//	$tmp .= "\n";
	$tmp .= "\n";
	$tmp .= '	$rc = $'.$table_schema.'__'.$table_name.'->add();'."\n";
	$tmp .= '	if ($rc->is_ok() === false) return $rc;'."\n";


	$tmp .= "\n";
	$tmp .= "\n";
	$tmp .= "// cnt ".$table_name."\n";
	$tmp .= '	$rc = $'.$table_schema.'__'.$table_name.'->cnt([ "filter"=> [ "flag_valid"=> "true" ] ]);'."\n";
	$tmp .= '	if ($rc->is_ok() === false) return $rc;'."\n";
	$tmp .= '	$count = $rc->get_value();'."\n";
	$tmp .= '	echo "count: ".$count."\n";'."\n";


	$tmp .= "\n";
	$tmp .= "\n";
	$tmp .= "// get ".$table_name."\n";
	$tmp .= '	$rc = $'.$table_schema.'__'.$table_name.'->get([ "filter"=> [ "flag_valid"=> "true" ], "sort"=> [ "id"=> "DESC" ], "offset"=> null, "limit"=> null, "expect_count"=> null, "lock"=> false ]);'."\n";
	$tmp .= '	if ($rc->is_ok() === false) return $rc;'."\n";
	$tmp .= '	$obj_list = $rc->get_value();'."\n";
	$tmp .= '	echo "obj_list: ".print_r($obj_list, true)."\n";'."\n";


	$tmp .= "\n";
	$tmp .= "\n";
	$tmp .= "// get ".$table_name."\n";
	$tmp .= '	$rc = $'.$table_schema.'__'.$table_name.'->get([ "filter"=> [ "id"=> "06", "flag_valid"=> "true" ], "expect_count"=> 1, "lock"=> true ]);'."\n";
	$tmp .= '	if ($rc->is_ok() === false) return $rc;'."\n";
	$tmp .= '	$obj_list = $rc->get_value();'."\n";
	$tmp .= '	echo "obj_list: ".print_r($obj_list, true)."\n";'."\n";


	$tmp .= "\n";
	$tmp .= "\n";
	$tmp .= "// set ".$table_name."\n";
	$tmp .= '	$'.$table_schema.'__'.$table_name.'->flag_valid = \'0\';'."\n";
	$tmp .= "\n";
	$tmp .= '	$rc = $public__client->set([ "filter"=> [ "id"=> "06" ] ]);'."\n";
	$tmp .= '	if ($rc->is_ok() === false) return $rc;'."\n";


	$tmp .= "\n";
	$tmp .= "\n";
	$tmp .= "// del ".$table_name."\n";
	$tmp .= '	$rc = $'.$table_schema.'__'.$table_name.'->del([ "filter"=> [ "id"=> "06" ] ]);'."\n";
	$tmp .= '	if ($rc->is_ok() === false) return $rc;'."\n";



	$tmp .= "*/"."\n";


	$result->set_ok();
	$result->set_value($tmp);
	return $result;
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function generate_model($arg, $plan_list)
{
	$result = new result_t(__FUNCTION__, __FILE__);


	$target_dir         = $arg->target_dir;
	$server_name        = $arg->server_name;
	$table_schema       = $arg->table_schema;
	$table_name         = $arg->table_name;
	$table_columns_list = $arg->table_columns_list;
	$table_name_short   = $arg->table_name_short;
	$model_name         = $arg->model_name;


	$table_columns_list_size = count($table_columns_list);
	$plan_list_size = count($plan_list);


	$max_col_name_size = 0;
	for ($i=0; $i < $table_columns_list_size; $i++)
	{
		$size = strlen($table_columns_list[$i]->column_name);

		if ($size > $max_col_name_size)
		{
			$max_col_name_size = $size;
		}
	}
	$max_col_name_size++;


	$max_col_type_size = 0;
	for ($i=0; $i < $table_columns_list_size; $i++)
	{
		$line = $table_columns_list[$i]->data_type_real;
		$size = strlen($line);


		if ($size > $max_col_type_size)
		{
			$max_col_type_size = $size;
		}
	}
	$max_col_type_size++;


//	print_r($table_columns_list);


	$tmp  = make_line();
	$tmp .= '// PLEASE DO NOT EDIT IT !!! THIS FILE IS GENERATED BY https://github.com/progman/reverse_orm.php'."\n";
	$tmp .= make_line();
	$tmp .= 'class orm__'.$table_schema."__".$table_name.'__t extends reverse_orm__model__t'."\n";
	$tmp .= "{"."\n";


	$rc = generate_example($arg);
	if ($rc->is_ok() === false) return $rc;
	$example = $rc->get_value();


	$tmp .= "\n";

	$tmp .= $example;

	$tmp .= "\n";
	$tmp .= "\n";


	$tmp .= '	protected $item_list;'."\n";

	$tmp .= "\n";
	$tmp .= "\n";

	$tmp .= '	protected $sql_handle;'."\n";

	$tmp .= "\n";
	$tmp .= "\n";

	$tmp .= '	protected $flag_debug;'."\n";

	$tmp .= "\n";
	$tmp .= "\n";

	$tmp .= '	public function __construct($sql_handle = null, $flag_debug = false) // work in php5 and php7'."\n";
	$tmp .= '	{'."\n";
	$tmp .= '		$this->clear();'."\n";
	$tmp .= '		$this->sql_handle = $sql_handle;'."\n";
	$tmp .= '		$this->flag_debug = $flag_debug;'."\n";
	$tmp .= '	}'."\n";

	$tmp .= "\n";
	$tmp .= "\n";
/*
	$tmp .= '	public function __set($name, $value)'."\n";
	$tmp .= '	{'."\n";
	$tmp .= '//		echo "__set(): name: ".$name.", value: ".$value."\n";'."\n";
	$tmp .= "\n";
	$tmp .= '		$this->item->$name = $value;'."\n";
	$tmp .= "\n";
	$tmp .= '//		print_r($this->item);'."\n";
	$tmp .= '	}'."\n";


	$tmp .= "\n";
	$tmp .= "\n";
*/

	$tmp .= "	public function get_reverse_orm_version()\n";
	$tmp .= "	{\n";
	$tmp .= "		return \"0.0.1\";\n";
	$tmp .= "	}\n";


	$tmp .= "\n";
	$tmp .= "\n";


	$tmp .= "	public function get_build_id()\n";
	$tmp .= "	{\n";
	$tmp .= "		return \"".bin2hex(libcore__rnd_bin_string(64))."\";\n";
	$tmp .= "	}\n";


	$tmp .= "\n";
	$tmp .= "\n";


	$tmp .= "	public function get_model_name()\n";
	$tmp .= "	{\n";
	$tmp .= "		return \"".$table_schema."__".$table_name."__t"."\";\n";
	$tmp .= "	}\n";


	$tmp .= "\n";
	$tmp .= "\n";


	$tmp .= "	public function get_table_name()\n";
	$tmp .= "	{\n";
	$tmp .= "		return \"".$table_schema.".".$table_name."\";\n";
	$tmp .= "	}\n";


	$tmp .= "\n";
	$tmp .= "\n";


	$tmp .= "	public function get_key_list()\n";
	$tmp .= "	{\n";
	$tmp .= "		return\n";
	$tmp .= "		[\n";


	for ($i=0; $i < $table_columns_list_size; $i++)
	{
		$tmp .= "			"."\"".$table_columns_list[$i]->column_name."\"";
		$size = $max_col_name_size - strlen($table_columns_list[$i]->column_name);

		for ($j=0; $j < $size; $j++)
		{
			$tmp .= " ";
		}
		$tmp .= "=> [ \"type\"=> \"";


		$line = $table_columns_list[$i]->data_type_real;
		$size = $max_col_type_size - strlen($line);


		$tmp .= $line;
		$tmp .= "\",";
		for ($j=0; $j < $size; $j++)
		{
			$tmp .= " ";
		}


		$tmp .= "\"is_nullable\"=> ";

		if (strcmp($table_columns_list[$i]->is_nullable, "YES") === 0)
		{
			$tmp .= "true,  ";
		}
		else
		{
			$tmp .= "false, ";
		}


		$tmp .= "\"is_updatable\"=> ";

		if (strcmp($table_columns_list[$i]->is_updatable, "YES") === 0)
		{
			$tmp .= "true ";
		}
		else
		{
			$tmp .= "false";
		}


		$tmp .= " ]";


		if (($i + 1) !== $table_columns_list_size)
		{
			$tmp .= ",";
		}


		$tmp .= "\n";
	}


	$tmp .= "		];\n";
	$tmp .= "	}\n";


	$tmp .= "\n";
	$tmp .= "\n";


	$tmp .= "	public function get_auto_action_list()\n";
	$tmp .= "	{\n";
	$tmp .= "		return\n";
	$tmp .= "		[\n";


	for ($i=0; $i < $plan_list_size; $i++)
	{
		$name = $plan_list[$i]->name;


		$tmp .= "			[ \"name\"=> \"ORM_ADD_".$name."\", \"type\"=> \"ADD\", \"func\"=> \"sql_orm_add__".$table_schema."__".$table_name."__".$name."\", \"filter_list\"=> [";


		$filter_size = count($plan_list[$i]->filter);
		if ($filter_size !== 0)
		{
			$tmp .= " ";
		}
		for ($j=0; $j < $filter_size; $j++)
		{
			$tmp .= "\"".$plan_list[$i]->filter[$j]."\"";
			if (($j + 1) != $filter_size)
			{
				$tmp .= ", ";
			}
		}
		if ($filter_size !== 0)
		{
			$tmp .= " ";
		}


		$tmp .= "], \"sort_list\"=> [";


		$sort_size = 0;
		foreach ($plan_list[$i]->sort as $key => $value)
		{
			$sort_size++;
		}
		if ($sort_size !== 0)
		{
			$tmp .= " ";
		}
		$j=0;
		foreach ($plan_list[$i]->sort as $key => $value)
		{
			if ($j != 0)
			{
				$tmp .= ", ";
			}
			$tmp .= "\"".$key."\"=> \"".$value."\"";
			$j++;
		}
		if ($sort_size !== 0)
		{
			$tmp .= " ";
		}


		$tmp .= "] ],\n";
	}
	$tmp .= "\n";


	for ($i=0; $i < $plan_list_size; $i++)
	{
		$name = $plan_list[$i]->name;


		$tmp .= "			[ \"name\"=> \"ORM_SET_".$name."\", \"type\"=> \"SET\", \"func\"=> \"sql_orm_set__".$table_schema."__".$table_name."__".$name."\", \"filter_list\"=> [";


		$filter_size = count($plan_list[$i]->filter);
		if ($filter_size !== 0)
		{
			$tmp .= " ";
		}
		for ($j=0; $j < $filter_size; $j++)
		{
			$tmp .= "\"".$plan_list[$i]->filter[$j]."\"";
			if (($j + 1) != $filter_size)
			{
				$tmp .= ", ";
			}
		}
		if ($filter_size !== 0)
		{
			$tmp .= " ";
		}


		$tmp .= "], \"sort_list\"=> [";


		$sort_size = 0;
		foreach ($plan_list[$i]->sort as $key => $value)
		{
			$sort_size++;
		}
		if ($sort_size !== 0)
		{
			$tmp .= " ";
		}
		$j=0;
		foreach ($plan_list[$i]->sort as $key => $value)
		{
			if ($j != 0)
			{
				$tmp .= ", ";
			}
			$tmp .= "\"".$key."\"=> \"".$value."\"";
			$j++;
		}
		if ($sort_size !== 0)
		{
			$tmp .= " ";
		}


		$tmp .= "] ],\n";
	}
	$tmp .= "\n";


	for ($i=0; $i < $plan_list_size; $i++)
	{
		$name = $plan_list[$i]->name;


		$tmp .= "			[ \"name\"=> \"ORM_CNT_".$name."\", \"type\"=> \"CNT\", \"func\"=> \"sql_orm_cnt__".$table_schema."__".$table_name."__".$name."\", \"filter_list\"=> [";


		$filter_size = count($plan_list[$i]->filter);
		if ($filter_size !== 0)
		{
			$tmp .= " ";
		}
		for ($j=0; $j < $filter_size; $j++)
		{
			$tmp .= "\"".$plan_list[$i]->filter[$j]."\"";
			if (($j + 1) != $filter_size)
			{
				$tmp .= ", ";
			}
		}
		if ($filter_size !== 0)
		{
			$tmp .= " ";
		}


		$tmp .= "], \"sort_list\"=> [";


		$sort_size = 0;
		foreach ($plan_list[$i]->sort as $key => $value)
		{
			$sort_size++;
		}
		if ($sort_size !== 0)
		{
			$tmp .= " ";
		}
		$j=0;
		foreach ($plan_list[$i]->sort as $key => $value)
		{
			if ($j != 0)
			{
				$tmp .= ", ";
			}
			$tmp .= "\"".$key."\"=> \"".$value."\"";
			$j++;
		}
		if ($sort_size !== 0)
		{
			$tmp .= " ";
		}


		$tmp .= "] ],\n";
	}
	$tmp .= "\n";


	for ($i=0; $i < $plan_list_size; $i++)
	{
		$name = $plan_list[$i]->name;


		$tmp .= "			[ \"name\"=> \"ORM_GET_".$name."\", \"type\"=> \"GET\", \"func\"=> \"sql_orm_get__".$table_schema."__".$table_name."__".$name."\", \"filter_list\"=> [";


		$filter_size = count($plan_list[$i]->filter);
		if ($filter_size !== 0)
		{
			$tmp .= " ";
		}
		for ($j=0; $j < $filter_size; $j++)
		{
			$tmp .= "\"".$plan_list[$i]->filter[$j]."\"";
			if (($j + 1) != $filter_size)
			{
				$tmp .= ", ";
			}
		}
		if ($filter_size !== 0)
		{
			$tmp .= " ";
		}


		$tmp .= "], \"sort_list\"=> [";


		$sort_size = 0;
		foreach ($plan_list[$i]->sort as $key => $value)
		{
			$sort_size++;
		}
		if ($sort_size !== 0)
		{
			$tmp .= " ";
		}
		$j=0;
		foreach ($plan_list[$i]->sort as $key => $value)
		{
			if ($j != 0)
			{
				$tmp .= ", ";
			}
			$tmp .= "\"".$key."\"=> \"".$value."\"";
			$j++;
		}
		if ($sort_size !== 0)
		{
			$tmp .= " ";
		}


		$tmp .= "] ],\n";
	}
	$tmp .= "\n";


	for ($i=0; $i < $plan_list_size; $i++)
	{
		$name = $plan_list[$i]->name;


		$tmp .= "			[ \"name\"=> \"ORM_DEL_".$name."\", \"type\"=> \"DEL\", \"func\"=> \"sql_orm_del__".$table_schema."__".$table_name."__".$name."\", \"filter_list\"=> [";


		$filter_size = count($plan_list[$i]->filter);
		if ($filter_size !== 0)
		{
			$tmp .= " ";
		}
		for ($j=0; $j < $filter_size; $j++)
		{
			$tmp .= "\"".$plan_list[$i]->filter[$j]."\"";
			if (($j + 1) != $filter_size)
			{
				$tmp .= ", ";
			}
		}
		if ($filter_size !== 0)
		{
			$tmp .= " ";
		}


		$tmp .= "], \"sort_list\"=> [";


		$sort_size = 0;
		foreach ($plan_list[$i]->sort as $key => $value)
		{
			$sort_size++;
		}
		if ($sort_size !== 0)
		{
			$tmp .= " ";
		}
		$j=0;
		foreach ($plan_list[$i]->sort as $key => $value)
		{
			if ($j != 0)
			{
				$tmp .= ", ";
			}
			$tmp .= "\"".$key."\"=> \"".$value."\"";
			$j++;
		}
		if ($sort_size !== 0)
		{
			$tmp .= " ";
		}


		if (($i + 1) === $plan_list_size)
		{
			$tmp .= "] ]\n";
		}
		else
		{
			$tmp .= "] ],\n";
		}
	}
//	$tmp .= "\n";


	$tmp .= "		];\n";
	$tmp .= "	}\n";


/*
	$tmp .= "\n";
	$tmp .= "\n";


	$tmp .= '	function add()'."\n";
	$tmp .= '	{'."\n";
	$tmp .= '		$result = new result_t(__FUNCTION__, __FILE__, __LINE__);'."\n";

	$tmp .= "\n";
	$tmp .= "\n";

	$tmp .= '		if ($this->sql_handle === null)'."\n";
	$tmp .= '		{'."\n";
	$tmp .= '			$backtrace = debug_backtrace();'."\n";
	$tmp .= '			$result = new result_t($backtrace[0]["function"], $backtrace[0]["file"], $backtrace[0]["line"]);'."\n";

	$tmp .= "\n";

	$tmp .= '			$result->set_err(13, "in model \"".$this->get_model_name()."\" (table \"".$this->get_table_name()."\") sql_handle is not set in constructor");'."\n";
	$tmp .= '			return $result;'."\n";
	$tmp .= '		}'."\n";

	$tmp .= "\n";

	$tmp .= '		$key_list = $this->get_key_list();'."\n";

	$tmp .= "\n";

	$tmp .= '		foreach ($key_list as $key => $value)'."\n";
	$tmp .= '		{'."\n";
	$tmp .= '			if (array_key_exists($key, $this->item) === false)'."\n";
	$tmp .= '			{'."\n";
	$tmp .= '				$backtrace = debug_backtrace();'."\n";
	$tmp .= '				$result = new result_t($backtrace[0]["function"], $backtrace[0]["file"], $backtrace[0]["line"]);'."\n";

	$tmp .= "\n";

	$tmp .= '				$result->set_err(13, "in model \"".$this->get_model_name()."\" (table \"".$this->get_table_name()."\") key \"".$key."\" is not exist");'."\n";
	$tmp .= '				return $result;'."\n";
	$tmp .= '			}'."\n";

	$tmp .= "\n";

	$tmp .= '			if ($value["is_nullable"] === false)'."\n";
	$tmp .= '			{'."\n";
	$tmp .= '				if (is_null($this->item->$key) === true)'."\n";
	$tmp .= '				{'."\n";
	$tmp .= '					$backtrace = debug_backtrace();'."\n";
	$tmp .= '					$result = new result_t($backtrace[0]["function"], $backtrace[0]["file"], $backtrace[0]["line"]);'."\n";

	$tmp .= "\n";

	$tmp .= '					$result->set_err(13, "in model \"".$this->get_model_name()."\" (table \"".$this->get_table_name()."\") key \"".$key."\" must be not null");'."\n";
	$tmp .= '					return $result;'."\n";
	$tmp .= '				}'."\n";
	$tmp .= '			}'."\n";

	$tmp .= '		}'."\n";

	$tmp .= "\n";
	$tmp .= "\n";

	$tmp .= '		$func = null;'."\n";
	$tmp .= '		$auto_action_list_size = count($this->get_auto_action_list());'."\n";
	$tmp .= '		for ($i=0; $i < $auto_action_list_size; $i++)'."\n";
	$tmp .= '		{'."\n";
	$tmp .= '			if (strcmp($this->get_auto_action_list()[$i]["type"], "INSERT") === 0)'."\n";
	$tmp .= '			{'."\n";
	$tmp .= '				$filter = $this->get_auto_action_list()[$i]["filter"];'."\n";
	$tmp .= '				if (empty($filter) === true)'."\n";
	$tmp .= '				{'."\n";
	$tmp .= '					$func = $this->get_auto_action_list()[$i]["func"];'."\n";
	$tmp .= '					break;'."\n";
	$tmp .= '				}'."\n";
	$tmp .= '			}'."\n";
	$tmp .= '		}'."\n";

	$tmp .= "\n";

	$tmp .= '		if ($func === null)'."\n";
	$tmp .= '		{'."\n";
	$tmp .= '			$backtrace = debug_backtrace();'."\n";
	$tmp .= '			$result = new result_t($backtrace[0]["function"], $backtrace[0]["file"], $backtrace[0]["line"]);'."\n";

	$tmp .= "\n";

	$tmp .= '			$result->set_err(13, "in model \"".$this->get_model_name()."\" (table \"".$this->get_table_name()."\") method for this filter is not exist");'."\n";
	$tmp .= '			return $result;'."\n";
	$tmp .= '		}'."\n";

	$tmp .= "\n";

	$tmp .= '//		echo $func."\n";'."\n";

	$tmp .= "\n";

//<-->if (strcmp(gettype($uuid), 'string') !== 0)


//<>public function get_key_list()


//<>print_r($item);

	$tmp .= '		return $func($this->sql_handle, $this->item);'."\n";

	$tmp .= "\n";

	$tmp .= '//		$result->set_ok();'."\n";
	$tmp .= '//		return $result;'."\n";
	$tmp .= '	}'."\n";

	$tmp .= "\n";
	$tmp .= "\n";
*/

	$tmp .= "}"."\n";
	$tmp .= make_line();


	$filename = $target_dir.'/'.$server_name.'/'.$table_schema.'.'.$table_name.'/model.php';
//echo '['.$filename.']'."\n";
	$rc = libcore__file_set($filename, $tmp);
	if ($rc === false)
	{
		$result->set_err(1, 'can not save file');
		return $result;
	}




	$tmp  = make_line();
	$tmp .= 'class '.$table_schema.'__'.$table_name.'__t extends orm__'.$table_schema.'__'.$table_name.'__t'."\n";
	$tmp .= '{'."\n";

	$rc = generate_example($arg);
	if ($rc->is_ok() === false) return $rc;
	$example = $rc->get_value();


	$tmp .= "\n";

	$tmp .= $example;

	$tmp .= "\n";
	$tmp .= "\n";


	$tmp .= '	public function get_hand_action_list()'."\n";
	$tmp .= '	{'."\n";
	$tmp .= '		return'."\n";
	$tmp .= '		['."\n";
	$tmp .= '// you can add here your actions with your filters'."\n";
	$tmp .= '		];'."\n";
	$tmp .= '	}'."\n";
	$tmp .= '}'."\n";
	$tmp .= make_line();


	$filename = $target_dir.'/'.$server_name.'/'.$table_schema.'.'.$table_name.'/model_hand.php';
//echo '['.$filename.']'."\n";
	$rc = libcore__file_set($filename, $tmp, false);
	if ($rc === false)
	{
		$result->set_err(1, 'can not save file');
		return $result;
	}


	$result->set_ok();
	return $result;
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function do_it($arg)
{
	$result = new result_t(__FUNCTION__, __FILE__);


	$target_dir       = $arg->target_dir;
	$server_name      = $arg->server_name;
	$table_schema     = $arg->table_schema;
	$table_name       = $arg->table_name;
	$table_name_short = $arg->table_name_short;
	$model_name       = $arg->model_name;
	$filter_list      = $arg->filter_list;
	$sort_list        = $arg->sort_list;


	array_multisort($filter_list);
	array_multisort($sort_list);


	$filter_list_size = count($filter_list);
	$sort_list_size   = count($sort_list);


// check filter_list
	$flag_found_empty = false;
	for ($i=0; $i < $filter_list_size; $i++)
	{
		$inner_array_size = count($filter_list[$i]);
		if ($inner_array_size === 0)
		{
			$flag_found_empty = true;
		}


		$flag_simple_array = true;
		$index = 0;
		foreach ($filter_list[$i] as $key => $value)
		{
			if ($key !== $index)
			{
				$flag_simple_array = false;
				break;
			}
			$index++;

			if (is_string($value) === false)
			{
				$result->set_err(1, 'invalid filter_list, invalid item, it is not array of string');
				return $result;
			}
		}
		if ($flag_simple_array === false)
		{
			$result->set_err(1, 'invalid filter_list, invalid item, it is not array of string');
			return $result;
		}
	}
	if ($flag_found_empty === false)
	{
		array_unshift($filter_list, []);
		$filter_list_size++;
	}


// check sort_list
	$flag_found_empty = false;
	for ($i=0; $i < $sort_list_size; $i++)
	{
		if (is_object($sort_list[$i]) === false)
		{
			$result->set_err(1, 'invalid sort_list, item is not object');
			return $result;
		}


		foreach ($sort_list[$i] as $key => $value)
		{
			if (is_string($key) === false)
			{
				$result->set_err(1, 'invalid sort_list, invalid item, it is not object of string');
				return $result;
			}
			if (is_string($value) === false)
			{
				$result->set_err(1, 'invalid sort_list, invalid item, it is not object of string');
				return $result;
			}


			if (strcmp(strtolower($value), "asc") !== 0)
			{
				if (strcmp(strtolower($value), "desc") !== 0)
				{
					$result->set_err(1, 'invalid sort_list, invalid item, sort is not ASC and DESC');
					return $result;
				}
			}
		}
	}
	if ($flag_found_empty === false)
	{
		array_unshift($sort_list, []);
		$sort_list_size++;
	}


// get info about table
	echo libcore__draw_time()."get info about table \"".$table_schema.".".$table_name."\"\n";

	$rc = sql_select_list__table_columns($arg->sql_handle, $table_schema, $table_name);
	if ($rc->is_ok() === false) return $rc;
	$table_columns_list = $rc->get_value();
	$table_columns_list_size = count($table_columns_list);


	if ($table_columns_list_size === 0)
	{
		$result->set_err(1, 'table is not found');
		return $result;
	}
	$arg->table_columns_list = $table_columns_list;
	$arg->table_columns_list_size = $table_columns_list_size;


// convert info about table
	for ($i=0; $i < $table_columns_list_size; $i++)
	{
		if (strcmp($table_columns_list[$i]->data_type, 'ARRAY') === 0)
		{
			$table_columns_list[$i]->data_type_real = substr($table_columns_list[$i]->udt_name, 1)."[]";
		}
		else
		{
			$table_columns_list[$i]->data_type_real = $table_columns_list[$i]->data_type;
		}

		if (strcmp($table_columns_list[$i]->data_type_real, 'jsonb') === 0)
		{
			$table_columns_list[$i]->data_type_real = 'json';
		}

		if (strcmp($table_columns_list[$i]->data_type_real, 'jsonb[]') === 0)
		{
			$table_columns_list[$i]->data_type_real = 'json[]';
		}

		if (strcmp($table_columns_list[$i]->data_type_real, 'int8[]') === 0)
		{
			$table_columns_list[$i]->data_type_real = 'bigint[]';
		}

		if (strcmp($table_columns_list[$i]->data_type_real, 'bool[]') === 0)
		{
			$table_columns_list[$i]->data_type_real = 'boolean[]';
		}

		if (strcmp($table_columns_list[$i]->data_type_real, 'timestamp without time zone') === 0)
		{
			$table_columns_list[$i]->data_type_real = 'timestamp';
		}

		if (strcmp($table_columns_list[$i]->data_type_real, 'timestamp[]') === 0)
		{
			$table_columns_list[$i]->data_type_real = 'timestamp[]';
		}
	}


// get info about primary key
	echo libcore__draw_time()."get info about PRIMARY KEY in table \"".$table_schema.".".$table_name."\"\n";

	$rc = sql_select_list__table_pks($arg->sql_handle, $table_schema, $table_name);
	if ($rc->is_ok() === false) return $rc;
	$pk_name_list = $rc->get_value();
	$pk_name_list_size = count($pk_name_list);

	if ($pk_name_list === null)
	{
		$result->set_err(1, 'PRIMARY KEY is not found in table');
		return $result;
	}

	array_multisort($pk_name_list);


	$arg->pk_name_list = $pk_name_list;
	$arg->pk_name_list_size = $pk_name_list_size;


// is primary key in filters?
	$flag_found = false;
	for ($i=0; $i < $filter_list_size; $i++)
	{
		$filter = $filter_list[$i];

		array_multisort($filter);

		if (libcore__cmp_value($pk_name_list, $filter) === true)
		{
			$flag_found = true;
			break;
		}
	}
	if ($flag_found === false)
	{
		$result->set_err(1, 'PRIMARY KEY is not found in filter');
		return $result;
	}


// prepare store place
	$rc = prepare_store($arg);
	if ($rc->is_ok() === false) return $rc;


// make plan
	$plan_list = array();
	$index = 1;

	for ($i=0; $i < $filter_list_size; $i++)
	{
		for ($j=0; $j < $sort_list_size; $j++)
		{
			$plan_item = new stdClass();
			$plan_item->name   = sprintf("%04s", $index++);
			$plan_item->filter = $filter_list[$i];
			$plan_item->sort   = $sort_list[$j];
			array_push($plan_list, $plan_item);
		}
	}
	$plan_list_size = count($plan_list);


// generate insert
	for ($i=0; $i < $plan_list_size; $i++)
	{
		$rc = generate_insert($arg, $plan_list[$i]);
		if ($rc->is_ok() === false) return $rc;
	}


// generate update
	for ($i=0; $i < $plan_list_size; $i++)
	{
		$rc = generate_update($arg, $plan_list[$i]);
		if ($rc->is_ok() === false) return $rc;
	}


// generate select_count
	for ($i=0; $i < $plan_list_size; $i++)
	{
		$rc = generate_select_count($arg, $plan_list[$i]);
		if ($rc->is_ok() === false) return $rc;
	}


// generate select
	for ($i=0; $i < $plan_list_size; $i++)
	{
		$rc = generate_select_list($arg, $plan_list[$i]);
		if ($rc->is_ok() === false) return $rc;
	}


// generate delete
	for ($i=0; $i < $plan_list_size; $i++)
	{
		$rc = generate_delete($arg, $plan_list[$i]);
		if ($rc->is_ok() === false) return $rc;
	}


// generate model
	$rc = generate_model($arg, $plan_list);
	if ($rc->is_ok() === false) return $rc;


	$result->set_ok();
	return $result;
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function action($arg)
{
	$result = new result_t(__FUNCTION__, __FILE__);


	$config_str = libcore__file_get($arg->config);
	if ($config_str === false)
	{
		$result->set_err(1, 'invalid config');
		return $result;
	}


	$config = json_decode($config_str);
	if (json_last_error() !== JSON_ERROR_NONE)
	{
		$result->set_err(1, 'invalid config');
		return $result;
	}


	if (is_array($config->{"table_list"}) === false)
	{
		$result->set_err(1, 'invalid config, invalid table_list');
		return $result;
	}


	$link_list = [];


	$table_list_size = count($config->{"table_list"});
	for ($i=0; $i < $table_list_size; $i++)
	{
		if (is_object($config->{"table_list"}[$i]) === false)
		{
			$result->set_err(1, 'invalid config, invalid table_list, item is not object');
			return $result;
		}

		if (is_string($config->{"table_list"}[$i]->{"server_name"}) === false)
		{
			$result->set_err(1, 'invalid config, invalid table_list, invalid server_name');
			return $result;
		}

		if (is_string($config->{"table_list"}[$i]->{"table_schema"}) === false)
		{
			$result->set_err(1, 'invalid config, invalid table_list, invalid table_schema');
			return $result;
		}

		if (is_string($config->{"table_list"}[$i]->{"table_name"}) === false)
		{
			$result->set_err(1, 'invalid config, invalid table_list, invalid table_name');
			return $result;
		}

		if (is_string($config->{"table_list"}[$i]->{"table_name_short"}) === false)
		{
			$result->set_err(1, 'invalid config, invalid table_list, invalid table_name_short');
			return $result;
		}

		if (is_string($config->{"table_list"}[$i]->{"model_name"}) === false)
		{
			$result->set_err(1, 'invalid config, invalid table_list, invalid model_name');
			return $result;
		}

		if (is_array($config->{"table_list"}[$i]->{"filter_list"}) === false)
		{
			$result->set_err(1, 'invalid config, invalid table_list, invalid filter_list');
			return $result;
		}

		if (is_array($config->{"table_list"}[$i]->{"sort_list"}) === false)
		{
			$result->set_err(1, 'invalid config, invalid table_list, invalid sort_list');
			return $result;
		}


		$arg->server_name      = $config->{"table_list"}[$i]->{"server_name"};
		$arg->table_schema     = $config->{"table_list"}[$i]->{"table_schema"};
		$arg->table_name       = $config->{"table_list"}[$i]->{"table_name"};
		$arg->table_name_short = $config->{"table_list"}[$i]->{"table_name_short"};
		$arg->model_name       = $config->{"table_list"}[$i]->{"model_name"};
		$arg->filter_list      = $config->{"table_list"}[$i]->{"filter_list"};
		$arg->sort_list        = $config->{"table_list"}[$i]->{"sort_list"};

		$rc = do_it($arg);
		if ($rc->is_ok() === false) return $rc;


		array_push($link_list, $arg->target_dir.'/'.$arg->server_name."\n");
	}


	$link_list = libcore__array_uniq($link_list);


// show dirs for link
	if (isset($arg->link_list) !== false)
	{
		$link_list_size = count($link_list);
		for ($i=0; $i < $link_list_size; $i++)
		{
			$rc = libcore__file_add($arg->link_list, $link_list[$i]);
			if ($rc === false)
			{
				$result->set_err(1, 'can not save file');
				return $result;
			}
		}
	}


	$result->set_ok();
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