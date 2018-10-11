#!/bin/bash
#---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
export CONFIG='./reverse_orm.json';
export TARGET_DIR='./';
#---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
function reverse_orm_link()
{
	local FILE;


	echo "[$(date +'%Y-%m-%d %H:%M:%S')]: link for ${1}";


	rm -rf "${1}/sql_mix.php" &> /dev/null < /dev/null;
	rm -rf "${1}/model_mix.php" &> /dev/null < /dev/null;


	echo "<?php" >> "${1}/sql_mix.php";
	for FILE in $(find "${1}" -type f | grep -v model.php | grep -v sql_mix.php | grep -v model_mix.php | grep -v hand.php);
	do

		cat -- "${FILE}" >> "${1}/sql_mix.php";

	done
	echo -n "?>" >> "${1}/sql_mix.php";


	echo "<?php" >> "${1}/model_mix.php";
	for FILE in $(find "${1}" -type f | grep model.php);
	do

		cat -- "${FILE}" >> "${1}/model_mix.php";

	done

	for FILE in $(find "${1}" -type f | grep hand.php);
	do

		cat -- "${FILE}" >> "${1}/model_mix.php";

	done
	echo -n "?>" >> "${1}/model_mix.php";
}
#---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
function main()
{
	if [ ! -f "${CONFIG}" ];
	then
		echo "ERROR: config file is not found";
		return 1;
	fi


	if [ ! -d "${TARGET_DIR}" ];
	then
		echo "ERROR: target dir is not exit";
		return 1;
	fi


	local CONFIG=$(readlink -f ${CONFIG});
	local TARGET_DIR=$(readlink -f ${TARGET_DIR});
	local FILEREALNAME="$(readlink -f ${0})";
	local REVERSE_ORM_DIR="$(dirname ${FILEREALNAME})"


	if [ ! -d "${REVERSE_ORM_DIR}" ];
	then
		echo "ERROR: target dir is not exit";
		return 1;
	fi


	cd -- "${REVERSE_ORM_DIR}";


	if [ ! -f "reverse_orm.php" ];
	then
		echo "ERROR: reverse_orm.php is not found";
		return 1;
	fi


	if [ "$(which php)" == "" ];
	then
		echo "ERROR: php is not found";
		return 1;
	fi


# create temp dir and files
	local REVERSE_ORM_TMPDIR="/tmp";
	if [ "${TMPDIR}" != "" ] && [ -d "${TMPDIR}" ];
	then
		REVERSE_ORM_TMPDIR="${TMPDIR}";
	fi


	local TMP;
	TMP="$(mktemp --tmpdir="${REVERSE_ORM_TMPDIR}" 2> /dev/null)";
	if [ "${?}" != "0" ];
	then
		echo "can't make tmp file";
		return 1;
	fi


	export LINK_LIST="${TMP}";


	php ./reverse_orm.php;
	if [ "${?}" != "0" ];
	then
		return 1;
	fi


	for i in $(cat "${TMP}");
	do
		reverse_orm_link "${i}";
	done


	echo "[$(date +'%Y-%m-%d %H:%M:%S')]: make is done";


	rm -rf -- "${TMP}";


	return 0;
}
#---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
main "${@}";

exit "${?}";
#---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
