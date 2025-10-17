<?php
function str_consulta($str_consulta,$ini_ciclo,$filtro){
    $consulta="";
    
    if((strcmp($str_consulta,'gral_ini'))==0){
        $qr_ini_gral = "SELECT CONCAT('GENERAL') AS titulo_fila,
                        SUM(V398+V414) AS total_matricula,SUM(V390+V406) AS mat_hombres,SUM(V394+V410) AS mat_mujeres,
                        SUM(V509+V516+V523+V511+V518+V525+V510+V517+V524+V512+V519+V526) AS total_docentes,SUM(V509+V516+V523+V511+V518+V525) AS doc_hombres,SUM(V510+V517+V524+V512+V519+V526) AS doc_mujeres,
                        COUNT(cv_cct) AS escuelas,SUM(V402+V418) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".ini_gral_".$ini_ciclo." 
                        WHERE (cv_estatus_captura = 0 OR cv_estatus_captura = 10) ".$filtro." ;";
                        //echo "<BR>".$qr_ini_gral."<BR>";
        $consulta=$qr_ini_gral;
    }
    if((strcmp($str_consulta,'gral_ini_dir_grp'))==0){
        $qr_ini_gral_dir = "SELECT CONCAT('GENERAL DIR CON GRUPO') AS titulo_fila, 
                        SUM(0) AS total_matricula,SUM(0) AS mat_hombres,SUM(0) AS mat_mujeres, 
                        SUM(v787) AS total_docentes,SUM(v785) AS 
                        doc_hombres,SUM(v786) AS doc_mujeres, 
                        SUM(0) AS escuelas,SUM(0) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".ini_gral_".$ini_ciclo." 
                        WHERE (cv_estatus_captura = 0 OR cv_estatus_captura = 10) AND V478>'0' ".$filtro." ;";
                        //echo $qr_ini_gral_dir;
        $consulta=$qr_ini_gral_dir;
    }
    if((strcmp($str_consulta,'ind_ini'))==0){
        $qr_ini_ind = "SELECT CONCAT('INDIGENA') AS titulo_fila,SUM(V183+V184) AS total_matricula,SUM(V183) AS 	
                        mat_hombres,SUM(V184) AS mat_mujeres,SUM(V291) AS total_docentes,SUM(V211) AS doc_hombres,SUM(V212) AS doc_mujeres,COUNT(cv_cct) AS escuelas,SUM(V100) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".ini_ind_".$ini_ciclo." 
                        WHERE (cv_estatus_captura = 0 OR cv_estatus_captura = 10) ".$filtro." ;";
                        //echo $qr_ini_ind;
        $consulta=$qr_ini_ind;
    }
    if((strcmp($str_consulta,'lact_ini'))==0){
        $qr_ini_lact = "SELECT CONCAT('LACTANTE') AS titulo_fila,
                        SUM(V398) AS total_matricula,SUM(V390) AS mat_hombres,SUM(V394) AS mat_mujeres,
                        SUM(V509+V516+V523+V510+V517+V524) AS total_docentes,SUM(V509+V516+V523) AS doc_hombres,SUM(V510+V517+V524) AS doc_mujeres,
                        COUNT(cv_cct) AS escuelas,SUM(V402) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".ini_gral_".$ini_ciclo." 
                        WHERE (cv_estatus_captura = 0 OR cv_estatus_captura = 10) ".$filtro." ;";
                        //echo $qr_ini_lact;
        $consulta=$qr_ini_lact;
    }
    if((strcmp($str_consulta,'mater_ini'))==0){
        $qr_ini_mater = "SELECT CONCAT('MATERNAL') AS titulo_fila,
                        SUM(V414) AS total_matricula,SUM(V406) AS mat_hombres,SUM(V410) AS mat_mujeres,
                        SUM(V511+V518+V525+V512+V519+V526) AS total_docentes,SUM(V511+V518+V525) AS doc_hombres,SUM(V512+V519+V526) AS doc_mujeres,
                        COUNT(cv_cct) AS escuelas,SUM(V418) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".ini_gral_".$ini_ciclo." 
                        WHERE (cv_estatus_captura = 0 OR cv_estatus_captura = 10) ".$filtro." ;";
                        //echo $qr_ini_mater;
        $consulta=$qr_ini_mater;
    }
    if((strcmp($str_consulta,'comuni_ini'))==0){
        $qr_ini_comuni = "SELECT CONCAT('GENERAL') AS titulo_fila,
                        SUM(V81) AS total_matricula,SUM(V79) AS mat_hombres,SUM(V80) AS mat_mujeres,
                        SUM(V126) AS total_docentes,SUM(V124) AS doc_hombres,SUM(V125) AS doc_mujeres,
                        COUNT(cv_cct) AS escuelas,SUM(0) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".ini_comuni_".$ini_ciclo." 
                        WHERE (cv_estatus_captura = 0 OR cv_estatus_captura = 10) ".$filtro." ;";
                        //echo $qr_ini_comuni;
        $consulta=$qr_ini_comuni;
    }
    if((strcmp($str_consulta,'ne_ini'))==0){
        $qr_ini_ne = "SELECT CONCAT('NO ESCOLARIZADA') AS titulo_fila,SUM(V129 + V130) AS total_matricula,SUM(V129) AS 	
                        mat_hombres,SUM(V130) AS mat_mujeres,SUM(V183 + V184) AS total_docentes,SUM(V183) AS doc_hombres,SUM(V184) AS doc_mujeres,
                        COUNT(cv_cct) AS escuelas,SUM(0) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".ini_ne_".$ini_ciclo." 
                        WHERE (cv_estatus_captura = 0 OR cv_estatus_captura = 10) ".$filtro." ;";
                        //echo $qr_ini_ne;
        $consulta=$qr_ini_ne;
    }		


    if((strcmp($str_consulta,'ini_1ro_pree'))==0){
        $qr_ini_1ro = "SELECT CONCAT('INI_1ro') AS titulo_fila,SUM(V478) AS total_matricula,SUM(V466) AS mat_hombres,SUM(V472) AS mat_mujeres,
                        SUM(V513+V520+V527+V514+V521+V528) AS total_docentes,
                        SUM(V513+V520+V527) AS doc_hombres,
                        SUM(V514+V521+V528) AS doc_mujeres,
                        SUM(0) AS escuelas,SUM(V479) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".ini_gral_".$ini_ciclo." 
                        WHERE (cv_estatus_captura = 0 OR cv_estatus_captura = 10) AND V478>'0' ".$filtro." ;";
                        //echo $qr_ini_1ro;
        $consulta=$qr_ini_1ro;
    }
    if((strcmp($str_consulta,'gral_pree'))==0){
        $qr_pree_gral = "SELECT CONCAT('GENERAL') AS titulo_fila,
                        SUM(V177) AS total_matricula,SUM(V165) AS mat_hombres,SUM(V171) AS mat_mujeres,
                        SUM(V867+V868+V859+V860) AS total_docentes,SUM(V859+V867) AS doc_hombres,SUM(V860+V868) AS doc_mujeres,
                        COUNT(cv_cct) AS escuelas,SUM(V182) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".pree_gral_".$ini_ciclo." 
                        WHERE (cv_estatus_captura = 0 OR cv_estatus_captura = 10) ".$filtro." ;";
                        //echo $qr_pree_gral;
        $consulta=$qr_pree_gral;
    }
    if((strcmp($str_consulta,'ind_pree'))==0){
        $qr_pree_ind = "SELECT CONCAT('INDIGENA') AS titulo_fila,SUM(V177) AS total_matricula,SUM(V165) AS 	
                        mat_hombres,SUM(V171) AS mat_mujeres,SUM(V795+V803+V796+V804) AS total_docentes,SUM(V795+V803) AS doc_hombres,SUM(V796+V804) AS doc_mujeres,COUNT(cv_cct) AS escuelas,SUM(V182) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".pree_ind_".$ini_ciclo." 
                        WHERE (cv_estatus_captura = 0 OR cv_estatus_captura = 10) ".$filtro." ;";
                        //echo $qr_pree_ind;
        $consulta=$qr_pree_ind;
    }
    if((strcmp($str_consulta,'comuni_pree'))==0){
        $qr_pree_comuni = "SELECT CONCAT('COMUNITARIO') AS titulo_fila,
                        SUM(V97) AS total_matricula,SUM(V85) AS mat_hombres,SUM(V91) AS mat_mujeres,
                        SUM(V151) AS total_docentes,SUM(V149) AS doc_hombres,SUM(V150) AS doc_mujeres,
                        COUNT(cv_cct) AS escuelas,(COUNT(cv_cct)-SUM(V78)) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".pree_comuni_".$ini_ciclo." 
                        WHERE (cv_estatus_captura = 0 OR cv_estatus_captura = 10) ".$filtro." ;";
                        //echo $qr_pree_comuni;
        $consulta=$qr_pree_comuni;
    }
    
    
    if((strcmp($str_consulta,'gral_prim'))==0){
        $qr_prim_gral = "SELECT CONCAT('GENERAL') AS titulo_fila,SUM(V608) AS total_matricula,SUM(V562+V573) AS 	
                        mat_hombres,SUM(V585+V596) AS mat_mujeres,SUM(V1575+V1576+V1567+V1568) AS total_docentes,SUM(V1575+V1567) AS doc_hombres,SUM(V1576+V1568) AS doc_mujeres,COUNT(cv_cct) AS escuelas,SUM(V616) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".prim_gral_".$ini_ciclo." 
                        WHERE (cv_estatus_captura = 0 OR cv_estatus_captura = 10) ".$filtro." ;";
                        //echo $qr_prim_gral;
        $consulta=$qr_prim_gral;
    }
    if((strcmp($str_consulta,'ind_prim'))==0){
        $qr_prim_ind = "SELECT CONCAT('INDIGENA') AS titulo_fila,SUM(V610) AS total_matricula,SUM(V564+V575) AS 	
                        mat_hombres,SUM(V587+V598) AS mat_mujeres,SUM(V1507+V1499+V1508+V1500) AS total_docentes,SUM(V1507+V1499) AS doc_hombres,SUM(V1508+V1500) AS doc_mujeres,COUNT(cv_cct) AS escuelas,SUM(V1052) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".prim_ind_".$ini_ciclo." 
                        WHERE (cv_estatus_captura = 0 OR cv_estatus_captura = 10) ".$filtro." ;";
                        //echo $qr_prim_ind;
        $consulta=$qr_prim_ind;
    }
    if((strcmp($str_consulta,'comuni_prim'))==0){
        $qr_prim_comuni = "SELECT CONCAT('COMUNITARIO') AS titulo_fila,SUM(V515) AS total_matricula,SUM(V469+V480) AS 	
                        mat_hombres,SUM(V492+V503) AS mat_mujeres,SUM(V585) AS total_docentes,SUM(V583) AS doc_hombres,SUM(V584) AS doc_mujeres,COUNT(cv_cct) AS escuelas,COUNT(cv_cct) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".prim_comuni_".$ini_ciclo." 
                        WHERE (cv_estatus_captura = 0 OR cv_estatus_captura = 10) ".$filtro." ;";
                        //echo $qr_prim_comuni;
        $consulta=$qr_prim_comuni;
    }
    
    
    if((strcmp($str_consulta,'gral_sec'))==0){
        $qr_sec_gral = "SELECT CONCAT('GENERAL') AS titulo_fila,SUM(V340) AS total_matricula,SUM(V306+V314) AS 	
                        mat_hombres,SUM(V323+V331) AS mat_mujeres,SUM(V1401) AS total_docentes,SUM(V1297+V1303+V1307+V1309+V1311+V1313) AS doc_hombres,SUM(V1298+V1304+V1308+V1310+V1312+V1314) AS doc_mujeres,COUNT(cv_cct) AS escuelas,SUM(V341) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".sec_gral_".$ini_ciclo." 
                        WHERE (cv_estatus_captura = 0 OR cv_estatus_captura = 10) ".$filtro." ;";
                        //echo $qr_sec_gral;
        $consulta=$qr_sec_gral;
    }
    if((strcmp($str_consulta,'sec_gral_gral'))==0){
        $qr_sec_gral_gral = "SELECT CONCAT('GENERAL') AS titulo_fila,SUM(V340) AS total_matricula,SUM(V306+V314) AS 	
                        mat_hombres,SUM(V323+V331) AS mat_mujeres,SUM(V1401) AS total_docentes,SUM(V1297+V1303+V1307+V1309+V1311+V1313) AS doc_hombres,SUM(V1298+V1304+V1308+V1310+V1312+V1314) AS doc_mujeres,COUNT(cv_cct) AS escuelas,SUM(V341) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".sec_gral_".$ini_ciclo." 
                        WHERE (cv_estatus_captura = 0 OR cv_estatus_captura = 10) AND subnivel='GENERAL' ".$filtro." ;";
                        //echo $qr_sec_gral_gral;
        $consulta=$qr_sec_gral_gral;
    }
    if((strcmp($str_consulta,'sec_gral_tele'))==0){
        $qr_sec_gral_tele = "SELECT CONCAT('TELESECUNDARIA') AS titulo_fila,SUM(V340) AS total_matricula,SUM(V306+V314) AS 	
                        mat_hombres,SUM(V323+V331) AS mat_mujeres,SUM(V1401) AS total_docentes,SUM(V1297+V1303+V1307+V1309+V1311+V1313) AS doc_hombres,SUM(V1298+V1304+V1308+V1310+V1312+V1314) AS doc_mujeres,COUNT(cv_cct) AS escuelas,SUM(V813) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".sec_gral_".$ini_ciclo." 
                        WHERE (cv_estatus_captura = 0 OR cv_estatus_captura = 10) AND subnivel='TELESECUNDARIA' ".$filtro." ;";
                        //echo $qr_sec_gral_tele;
        $consulta=$qr_sec_gral_tele;
    }
    if((strcmp($str_consulta,'sec_gral_tec'))==0){
        $qr_sec_gral_tec = "SELECT CONCAT('TECNICA') AS titulo_fila,SUM(V340) AS total_matricula,SUM(V306+V314) AS 	
                        mat_hombres,SUM(V323+V331) AS mat_mujeres,SUM(V1401) AS total_docentes,SUM(V1297+V1303+V1307+V1309+V1311+V1313) AS doc_hombres,SUM(V1298+V1304+V1308+V1310+V1312+V1314) AS doc_mujeres,COUNT(cv_cct) AS escuelas,SUM(V341) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".sec_gral_".$ini_ciclo." 
                        WHERE (cv_estatus_captura = 0 OR cv_estatus_captura = 10) AND subnivel<>'TELESECUNDARIA' AND subnivel<>'GENERAL' ".$filtro." ;";
                        //echo $qr_sec_gral_tec;
        $consulta=$qr_sec_gral_tec;
    }
    if((strcmp($str_consulta,'comuni_sec'))==0){
        $qr_sec_comuni = "SELECT CONCAT('COMUNITARIO') AS titulo_fila,SUM(V257) AS total_matricula,SUM(V223+V231) AS 	
                        mat_hombres,SUM(V240+V248) AS mat_mujeres,SUM(V386) AS total_docentes,SUM(V384) AS doc_hombres,SUM(V385) AS doc_mujeres,
                        COUNT(cv_cct) AS escuelas,COUNT(cv_cct) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".sec_comuni_".$ini_ciclo." 
                        WHERE (cv_estatus_captura = 0 OR cv_estatus_captura = 10) ".$filtro." ;";
                        //echo $qr_sec_comuni;
        $consulta=$qr_sec_comuni;
    }
    
    
    if((strcmp($str_consulta,'bgral_msup'))==0){
        $qr_msup_gral = "SELECT CONCAT('BACHILLERATO GENERAL') AS titulo_fila,
                        SUM(V397) AS total_matricula,SUM(V395) AS mat_hombres,SUM(V396) AS mat_mujeres,
                        SUM(V960) AS total_docentes,SUM(V958) AS doc_hombres,SUM(V959) AS doc_mujeres,
                        COUNT(DISTINCT CONCAT(cct_ins_pla,'-',cv_cct,'-',c_turno)) AS escuelas,SUM(V401) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".ms_gral_".$ini_ciclo." 
                        WHERE cv_motivo = '0' AND (cv_estatus<>'4' AND cv_estatus<>'2')  ".$filtro." ;";
                        //echo $qr_msup_gral;
        $consulta=$qr_msup_gral;
    }
    if((strcmp($str_consulta,'btecno_msup'))==0){
        $qr_msup_tecno = "SELECT CONCAT('BACHILLERATO TECNOLOGICO') AS titulo_fila,SUM(V472) AS total_matricula,SUM(V470) AS 	
                        mat_hombres,SUM(V471) AS mat_mujeres,SUM(V1059) AS total_docentes,SUM(V1057) AS doc_hombres,SUM(V1058) AS doc_mujeres,
                        COUNT(DISTINCT CONCAT(cct_ins_pla,'-',cv_cct,'-',c_turno)) AS escuelas,SUM(V476) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".ms_tecno_".$ini_ciclo." 
                        WHERE cv_motivo = '0' AND (cv_estatus<>'4' AND cv_estatus<>'2') ".$filtro." ;";
                        //echo $qr_msup_tecno;
        $consulta=$qr_msup_tecno;
    }
    if((strcmp($str_consulta,'btecno_tecno_msup'))==0){
        $qr_msup_tecno_btecno = "SELECT CONCAT('BACHILLERATO TECNOLOGICO') AS titulo_fila,SUM(V472) AS total_matricula,SUM(V470) AS 	
                        mat_hombres,SUM(V471) AS mat_mujeres,SUM(V1059) AS total_docentes,SUM(V1057) AS doc_hombres,SUM(V1058) AS doc_mujeres,
                        COUNT(DISTINCT CONCAT(cct_ins_pla,'-',cv_cct,'-',c_turno)) AS escuelas,SUM(V476) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".ms_tecno_".$ini_ciclo." 
                        WHERE cv_motivo = '0' AND (cv_estatus<>'4' AND cv_estatus<>'2') AND cv_servicion3='2' ".$filtro." ;";
                        //echo $qr_msup_tecno_btecno;
        $consulta=$qr_msup_tecno_btecno;
    }
    if((strcmp($str_consulta,'btecno_pbach_msup'))==0){
        $qr_msup_tecno_pbach = "SELECT CONCAT('BACHILLERATO TECNOLOGICO') AS titulo_fila,SUM(V472) AS total_matricula,SUM(V470) AS 	
                        mat_hombres,SUM(V471) AS mat_mujeres,SUM(V1059) AS total_docentes,SUM(V1057) AS doc_hombres,SUM(V1058) AS doc_mujeres,
                        COUNT(DISTINCT CONCAT(cct_ins_pla,'-',cv_cct,'-',c_turno)) AS escuelas,SUM(V476) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".ms_tecno_".$ini_ciclo." 
                        WHERE cv_motivo = '0'  AND (cv_estatus<>'4' AND cv_estatus<>'2') AND cv_servicion3='3' ".$filtro." ;";
                        //echo $qr_msup_tecno_pbach;
        $consulta=$qr_msup_tecno_pbach;
    }
    if((strcmp($str_consulta,'btecno_ptecno_msup'))==0){
        $qr_msup_tecno_ptecno = "SELECT CONCAT('BACHILLERATO TECNOLOGICO') AS titulo_fila,SUM(V472) AS total_matricula,SUM(V470) AS 	
                        mat_hombres,SUM(V471) AS mat_mujeres,SUM(V1059) AS total_docentes,SUM(V1057) AS doc_hombres,SUM(V1058) AS doc_mujeres,
                        COUNT(DISTINCT CONCAT(cct_ins_pla,'-',cv_cct,'-',c_turno)) AS escuelas,SUM(V476) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".ms_tecno_".$ini_ciclo." 
                        WHERE cv_motivo = '0'  AND (cv_estatus<>'4' AND cv_estatus<>'2') AND cv_servicion3='4' ".$filtro." ;";
                        //echo $qr_msup_tecno_ptecno;
        $consulta=$qr_msup_tecno_ptecno;
    }
    if((strcmp($str_consulta,'plant_doc_esc_msup'))==0){
        $qr_doc_plant_msup = "SELECT CONCAT('DOCENTES PLANTEL') AS titulo_fila,
                        SUM(0) AS total_matricula,SUM(0) AS 	
                        mat_hombres,SUM(0) AS mat_mujeres,SUM(V106+V101) AS total_docentes,
                        SUM(V104+V99) AS doc_hombres,SUM(V105+V100) AS doc_mujeres,
                        COUNT(cct_ins_pla) AS escuelas,SUM(0) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".ms_plantel_".$ini_ciclo." 
                        WHERE cv_motivo = '0' ".$filtro." ;";
                        //echo $qr_doc_plant_msup;
        $consulta=$qr_doc_plant_msup;
    }
    if((strcmp($str_consulta,'bgral_escuelas_msup'))==0){
        $qr_cct_msup_gral = "SELECT CONCAT('ESCUELAS BACHILLERATO GENERAL') AS titulo_fila,
                        SUM(0) AS total_matricula,SUM(0) AS mat_hombres,SUM(0) AS mat_mujeres,
                        SUM(0) AS total_docentes,SUM(0) AS doc_hombres,SUM(0) AS doc_mujeres,
                        COUNT(DISTINCT CONCAT(cct_ins_pla,'-',cv_cct,'-',c_turno)) AS escuelas,SUM(0) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".ms_gral_".$ini_ciclo." 
                        WHERE cv_motivo = '0' AND (cv_estatus<>'4' AND cv_estatus<>'2') ".$filtro." ;";
                        //echo $qr_cct_msup_gral;
        $consulta=$qr_cct_msup_gral;
    }
    if((strcmp($str_consulta,'btecno_escuelas_msup'))==0){
        $qr_cct_msup_tecno = "SELECT CONCAT('BACHILLERATO TECNOLOGICO') AS titulo_fila,SUM(0) AS total_matricula,SUM(0) AS 	
                        mat_hombres,SUM(0) AS mat_mujeres,SUM(0) AS total_docentes,SUM(0) AS doc_hombres,SUM(0) AS doc_mujeres,COUNT(DISTINCT CONCAT(cct_ins_pla,'-',cv_cct,'-',c_turno)) AS escuelas,SUM(V476) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".ms_tecno_".$ini_ciclo." 
                        WHERE cv_motivo = '0' AND (cv_estatus<>'4' AND cv_estatus<>'2') ".$filtro." ;";
                        //echo $qr_cct_msup_tecno;
        $consulta=$qr_cct_msup_tecno;
    }
    
    
    if((strcmp($str_consulta,'carr_lic_sup'))==0){
        $qr_carr_sup = "SELECT CONCAT('LICENCIATURA') AS titulo_fila,
                        SUM(V177) AS total_matricula,SUM(V175) AS mat_hombres,SUM(V176) AS mat_mujeres,
                        SUM(0) AS total_docentes,SUM(0) AS doc_hombres,SUM(0) AS doc_mujeres,
                        COUNT(cct_ins_pla) AS escuelas,SUM(0) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".sup_carrera_".$ini_ciclo." 
                        WHERE cv_motivo = '0' ".$filtro." ;";
                        //echo $qr_carr_sup;
        $consulta=$qr_carr_sup;
    }
    if((strcmp($str_consulta,'carr_normal_sup'))==0){
        $qr_carr_sup_normal = "SELECT CONCAT('LICENCIATURA') AS titulo_fila,
                        SUM(V177) AS total_matricula,SUM(V175) AS mat_hombres,SUM(V176) AS mat_mujeres,
                        SUM(0) AS total_docentes,SUM(0) AS doc_hombres,SUM(0) AS doc_mujeres,
                        COUNT(cct_ins_pla) AS escuelas,SUM(0) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".sup_carrera_".$ini_ciclo." 
                        WHERE cv_motivo = '0' AND (subsistema_3 LIKE '%Normal%' OR subsistema_3 LIKE '%NORMAL%') ".$filtro." ;";
                        //echo $qr_carr_sup_normal;
        $consulta=$qr_carr_sup_normal;
    }
    if((strcmp($str_consulta,'carr_tecno_sup'))==0){
        $qr_carr_sup_tecno = "SELECT CONCAT('LICENCIATURA') AS titulo_fila,
                        SUM(V177) AS total_matricula,SUM(V175) AS mat_hombres,SUM(V176) AS mat_mujeres,
                        SUM(0) AS total_docentes,SUM(0) AS doc_hombres,SUM(0) AS doc_mujeres,
                        COUNT(cct_ins_pla) AS escuelas,SUM(0) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".sup_carrera_".$ini_ciclo." 
                        WHERE cv_motivo = '0' AND (subsistema_3 NOT LIKE '%Normal%' AND subsistema_3 NOT LIKE '%NORMAL%') ".$filtro." ;";
                        //echo $qr_carr_sup_tecno;
        $consulta=$qr_carr_sup_tecno;
    }
    if((strcmp($str_consulta,'posgr_sup'))==0){
        $qr_posgr_sup = "SELECT CONCAT('POSGRADO') AS titulo_fila,
                        SUM(V142) AS total_matricula,SUM(V140) AS mat_hombres,SUM(V141) AS mat_mujeres,
                        SUM(0) AS total_docentes,SUM(0) AS doc_hombres,SUM(0) AS doc_mujeres,
                        COUNT(cct_ins_pla) AS escuelas,SUM(0) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".sup_posgrado_".$ini_ciclo." 
                        WHERE cv_motivo = '0' ".$filtro." ;";
                        //echo $qr_posgr_sup;
        $consulta=$qr_posgr_sup;
    }
    if((strcmp($str_consulta,'esc_lic_sup'))==0){
        $qr_esc_sup_lic = "SELECT CONCAT('ESCUELA') AS titulo_fila,
                        SUM(V214+V218) AS total_matricula,SUM(0) AS mat_hombres,SUM(0) AS mat_mujeres,
                        SUM(V944+V768) AS total_docentes,SUM(V942+V766) AS doc_hombres,SUM(V943+V767) AS doc_mujeres,
                        COUNT(cct_ins_pla) AS escuelas,SUM(0) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".sup_escuela_".$ini_ciclo." 
                        WHERE cv_motivo = '0' AND (V944>'0' OR V768>'0') ".$filtro." ;";
                        //echo $qr_esc_sup_lic;
        $consulta=$qr_esc_sup_lic;
    }
    if((strcmp($str_consulta,'esc_normal_sup'))==0){
        $qr_esc_sup_lic_normal = "SELECT CONCAT('ESCUELA') AS titulo_fila,
                        SUM(V214+V218) AS total_matricula,SUM(0) AS mat_hombres,SUM(0) AS mat_mujeres,
                        SUM(V944+V768) AS total_docentes,SUM(V942+V766) AS doc_hombres,SUM(V943+V767) AS doc_mujeres,
                        COUNT(cct_ins_pla) AS escuelas,SUM(0) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".sup_escuela_".$ini_ciclo." 
                        WHERE cv_motivo = '0' AND (V944>'0' OR V768>'0') AND (nombre_ins LIKE '%NORMAL%' OR nombre_ins LIKE '%INSTITUTO LA PAZ%') ".$filtro." ;";
                        //echo $qr_esc_sup_lic_normal;
        $consulta=$qr_esc_sup_lic_normal;
    }
    if((strcmp($str_consulta,'esc_tecno_sup'))==0){
        $qr_esc_sup_lic_tecno = "SELECT CONCAT('ESCUELA') AS titulo_fila,
                        SUM(V214+V218) AS total_matricula,SUM(0) AS mat_hombres,SUM(0) AS mat_mujeres,
                        SUM(V944+V768) AS total_docentes,SUM(V942+V766) AS doc_hombres,SUM(V943+V767) AS doc_mujeres,
                        COUNT(cct_ins_pla) AS escuelas,SUM(0) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".sup_escuela_".$ini_ciclo." 
                        WHERE cv_motivo = '0' AND (V944>'0' OR V768>'0') AND (nombre_ins NOT LIKE '%NORMAL%' AND nombre_ins NOT LIKE '%INSTITUTO LA PAZ%')  ".$filtro." ;";
                        //echo $qr_esc_sup_lic_tecno;
        $consulta=$qr_esc_sup_lic_tecno;
    }
    if((strcmp($str_consulta,'esc_posgr_sup'))==0){
        $qr_esc_sup_posgr = "SELECT CONCAT('ESCUELA') AS titulo_fila,
                        SUM(V220+V222+V224) AS total_matricula,SUM(0) AS mat_hombres,SUM(0) AS mat_mujeres,
                        SUM(V771) AS total_docentes,SUM(V769) AS doc_hombres,SUM(V770) AS doc_mujeres,
                        COUNT(cct_ins_pla) AS escuelas,SUM(0) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".sup_escuela_".$ini_ciclo." 
                        WHERE cv_motivo = '0' AND V771>'0' ".$filtro." ;";
                        //echo $qr_esc_sup_posgr;
        $consulta=$qr_esc_sup_posgr;
    }
    if((strcmp($str_consulta,'esc_carr_doc_sup'))==0){
        $qr_escuela_sup = "SELECT CONCAT('ESCUELA') AS titulo_fila,
                        SUM(V226) AS total_matricula,SUM(0) AS mat_hombres,SUM(0) AS mat_mujeres,
                        SUM(V944+V768+V771) AS total_docentes,SUM(V942+V766+V769) AS doc_hombres,SUM(V943+V767+V770) AS doc_mujeres,
                        COUNT(cct_ins_pla) AS escuelas,SUM(0) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".sup_escuela_".$ini_ciclo." 
                        WHERE cv_motivo = '0' AND (V944>'0' OR V768>'0' OR V771>'0') ".$filtro." ;";
                        //echo $qr_escuela_sup;
        $consulta=$qr_escuela_sup;
    }
    if((strcmp($str_consulta,'esc_docentes_sup'))==0){
        $qr_escuela_sup = "SELECT CONCAT('ESCUELA') AS titulo_fila,
                        SUM(0) AS total_matricula,SUM(0) AS mat_hombres,SUM(0) AS mat_mujeres,
                        SUM(V83) AS total_docentes,SUM(V81) AS doc_hombres,SUM(V82) AS doc_mujeres,
                        COUNT(cct_ins_pla) AS escuelas,SUM(0) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".sup_escuela_".$ini_ciclo." 
                        WHERE cv_motivo = '0' ".$filtro." ;";
                        //echo $qr_escuela_sup;
        $consulta=$qr_escuela_sup;
    }
    if((strcmp($str_consulta,'esc_sedeq_docentes_sup'))==0){
        $qr_escuela_sup = "SELECT CONCAT('ESCUELA') AS titulo_fila,
                        SUM(0) AS total_matricula,SUM(0) AS mat_hombres,SUM(0) AS mat_mujeres,
                        SUM(V83) AS total_docentes,SUM(V81) AS doc_hombres,SUM(V82) AS doc_mujeres,
                        COUNT(DISTINCT cct_ins_pla) AS escuelas,SUM(0) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".sup_escuela_".$ini_ciclo." 
                        WHERE cv_motivo = '0' ".$filtro." ;";
                        //echo $qr_escuela_sup;
        $consulta=$qr_escuela_sup;
    }
    if((strcmp($str_consulta,'esc_sedeq_doc_munic_sup'))==0){
        $qr_sedeq_escuela_sup = "SELECT CONCAT('ESCUELA') AS titulo_fila,
                        SUM(0) AS total_matricula,SUM(0) AS mat_hombres,SUM(0) AS mat_mujeres,
                        SUM(V83) AS total_docentes,SUM(V81) AS doc_hombres,SUM(V82) AS doc_mujeres,
                        COUNT(DISTINCT CONCAT(cct_ins_pla,'-',cv_mun)) AS escuelas,SUM(0) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".sup_escuela_".$ini_ciclo." 
                        WHERE cv_motivo = '0' ".$filtro." ;";
                        //echo $qr_sedeq_escuela_sup;
        $consulta=$qr_sedeq_escuela_sup;
    }
    if((strcmp($str_consulta,'carr_usbq_tsu_sup'))==0){
        $carr_usbq_tsu_sup = "SELECT CONCAT('LICENCIATURA') AS titulo_fila,
                        SUM(V177) AS total_matricula,SUM(V175) AS mat_hombres,SUM(V176) AS mat_mujeres,
                        SUM(0) AS total_docentes,SUM(0) AS doc_hombres,SUM(0) AS doc_mujeres,
                        COUNT(cct_ins_pla) AS escuelas,SUM(0) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".sup_carrera_".$ini_ciclo." 
                        WHERE cv_motivo = '0' AND cv_carrera LIKE '4%' ".$filtro." ;";
                        //echo $carr_usbq_tsu_sup;
        $consulta=$carr_usbq_tsu_sup;
    }
    if((strcmp($str_consulta,'carr_usbq_lic_sup'))==0){
        $carr_usbq_lic_sup = "SELECT CONCAT('LICENCIATURA') AS titulo_fila,
                        SUM(V177) AS total_matricula,SUM(V175) AS mat_hombres,SUM(V176) AS mat_mujeres,
                        SUM(0) AS total_docentes,SUM(0) AS doc_hombres,SUM(0) AS doc_mujeres,
                        COUNT(cct_ins_pla) AS escuelas,SUM(0) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".sup_carrera_".$ini_ciclo." 
                        WHERE cv_motivo = '0' AND cv_carrera LIKE '5%' ".$filtro." ;";
                        //echo $carr_usbq_lic_sup;
        $consulta=$carr_usbq_lic_sup;
    }
    if((strcmp($str_consulta,'esc_nesc_lic_sup'))==0){
        $qr_esc_sup_lic_ne = "SELECT CONCAT('ESCUELA') AS titulo_fila,
                        SUM(V468+V472) AS total_matricula,SUM(0) AS mat_hombres,SUM(0) AS mat_mujeres,
                        SUM(V962+V799) AS total_docentes,SUM(V961+V798) AS doc_hombres,SUM(V960+V797) AS doc_mujeres,
                        COUNT(cct_ins_pla) AS escuelas,SUM(0) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".sup_escuela_".$ini_ciclo." 
                        WHERE cv_motivo = '0' AND (V962>'0' OR V799>'0') ".$filtro." ;";
                        //echo $qr_esc_sup_lic_ne;
        $consulta=$qr_esc_sup_lic_ne;
    }	
    if((strcmp($str_consulta,'esc_nesc_normal_sup'))==0){
        $qr_esc_sup_lic_normal_ne = "SELECT CONCAT('ESCUELA') AS titulo_fila,
                        SUM(V468+V472) AS total_matricula,SUM(0) AS mat_hombres,SUM(0) AS mat_mujeres,
                        SUM(V962+V799) AS total_docentes,SUM(V961+V798) AS doc_hombres,SUM(V960+V797) AS doc_mujeres,
                        COUNT(cct_ins_pla) AS escuelas,SUM(0) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".sup_escuela_".$ini_ciclo." 
                        WHERE cv_motivo = '0' AND (V962>'0' OR V799>'0') AND (nombre_ins LIKE '%NORMAL%' OR nombre_ins LIKE '%INSTITUTO LA PAZ%') ".$filtro." ;";
                        //echo $qr_esc_sup_lic_normal_ne;
        $consulta=$qr_esc_sup_lic_normal_ne;
    }	
    if((strcmp($str_consulta,'esc_nesc_tecno_sup'))==0){
        $qr_esc_sup_lic_tecno_ne = "SELECT CONCAT('ESCUELA') AS titulo_fila,
                        SUM(V468+V472) AS total_matricula,SUM(0) AS mat_hombres,SUM(0) AS mat_mujeres,
                        SUM(V962+V799) AS total_docentes,SUM(V961+V798) AS doc_hombres,SUM(V960+V797) AS doc_mujeres,
                        COUNT(cct_ins_pla) AS escuelas,SUM(0) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".sup_escuela_".$ini_ciclo." 
                        WHERE cv_motivo = '0' AND (V962>'0' OR V799>'0') AND (nombre_ins NOT LIKE '%NORMAL%' AND nombre_ins NOT LIKE '%INSTITUTO LA PAZ%') ".$filtro." ;";
                        //echo $qr_esc_sup_lic_tecno_ne;
        $consulta=$qr_esc_sup_lic_tecno_ne;
    }		
    if((strcmp($str_consulta,'esc_nesc_posgr_sup'))==0){
        $qr_esc_sup_posgr_ne = "SELECT CONCAT('ESCUELA') AS titulo_fila,
                        SUM(V474+V478+V478) AS total_matricula,SUM(0) AS mat_hombres,SUM(0) AS mat_mujeres,
                        SUM(V802) AS total_docentes,SUM(V800) AS doc_hombres,SUM(V801) AS doc_mujeres,
                        COUNT(cct_ins_pla) AS escuelas,SUM(0) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".sup_escuela_".$ini_ciclo." 
                        WHERE cv_motivo = '0' AND V802>'0' ".$filtro." ;";
                        //echo $qr_esc_sup_posgr_ne;
        $consulta=$qr_esc_sup_posgr_ne;
    }	
    if((strcmp($str_consulta,'esc_nesc_sup'))==0){
        //(V962>'0' OR V799>'0' OR V802>'0') para filtrar las escuelas en esa modalidad 
        $qr_escuela_sup_ne = "SELECT CONCAT('ESCUELA') AS titulo_fila,
                        SUM(V480) AS total_matricula,SUM(0) AS mat_hombres,SUM(0) AS mat_mujeres,
                        SUM(V962+V799+V802) AS total_docentes,SUM(V960+V797+V800) AS doc_hombres,SUM(V961+V798+V801) AS doc_mujeres,
                        COUNT(cct_ins_pla) AS escuelas,SUM(0) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".sup_escuela_".$ini_ciclo." 
                        WHERE cv_motivo = '0' AND (V962>'0' OR V799>'0' OR V802>'0') ".$filtro." ;";
                        //echo $qr_escuela_sup_ne;
        $consulta=$qr_escuela_sup_ne;
    }
    if((strcmp($str_consulta,'unidades_sup'))==0){
        $qr_unidades_sup = "SELECT CONCAT('unidades') AS titulo_fila,
                        SUM(total_matricula) AS total_matricula,SUM(mat_hombres) AS mat_hombres,SUM(mat_mujeres) AS mat_mujeres,
                        SUM(total_docentes) AS total_docentes,SUM(doc_hombres) AS doc_hombres,SUM(doc_mujeres) AS doc_mujeres,
                        COUNT(DISTINCT cct_ins_pla) AS escuelas,SUM(0) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".sup_unidades_".$ini_ciclo." 
                        WHERE 1=1 ".$filtro." ;";
                        //echo $qr_unidades_sup;
        $consulta=$qr_unidades_sup;
    }
    
    
    if((strcmp($str_consulta,'especial_tot'))==0){
        $qr_especial_tot = "SELECT CONCAT('ESPECIAL_TOTAL') AS titulo_fila,
                        SUM(V2257) AS total_matricula,SUM(V2255) AS mat_hombres,SUM(V2256) AS mat_mujeres,
                        SUM(V2496) AS total_docentes,
                        SUM(V2311+V2319+V2327+V2335+V2343+V2351+V2359+V2367+V2375+V2383+V2391+V2399+V2407+V2415+V2423+V2431+V2440+V2449+V2458+V2467+V2476+V2485+V2494) AS doc_hombres,
                        SUM(V2312+V2320+V2328+V2336+V2344+V2352+V2360+V2368+V2376+V2384+V2392+V2400+V2408+V2416+V2424+V2432+V2441+V2450+V2459+V2468+V2477+V2486+V2495) AS doc_mujeres,
                        COUNT(cv_cct) AS escuelas,SUM(V1343+V1418+V1511+V1586+V1765) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".esp_cam_".$ini_ciclo." 
                        WHERE (cv_estatus_captura = 0) ".$filtro." ;";
                        //echo $qr_especial_tot;
        $consulta=$qr_especial_tot;
    }
    if((strcmp($str_consulta,'especial_ini'))==0){
        $qr_especial_ini = "SELECT CONCAT('ESPECIAL_INICIAL') AS titulo_fila,
                        SUM(V1338+V1340+V1339+V1341) AS total_matricula,SUM(V1338+V1340) AS mat_hombres,SUM(V1339+V1341) AS mat_mujeres,
                        SUM(V2496) AS total_docentes,SUM(V2302) AS doc_hombres,SUM(V2303) AS doc_mujeres,
                        COUNT(cv_cct) AS escuelas,SUM(V1343) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".esp_cam_".$ini_ciclo." 
                        WHERE (cv_estatus_captura = 0) ".$filtro." ;";
                        //echo $qr_especial_ini;
        $consulta=$qr_especial_ini;
    }
    if((strcmp($str_consulta,'especial_pree'))==0){
        $qr_especial_pree = "SELECT CONCAT('ESPECIAL_PREESCOLAR') AS titulo_fila,
                        SUM(V1413+V1415+V1414+V1416) AS total_matricula,SUM(V1413+V1415) AS mat_hombres,SUM(V1414+V1416) AS mat_mujeres,
                        SUM(V2496) AS total_docentes,SUM(V2302) AS doc_hombres,SUM(V2303) AS doc_mujeres,
                        COUNT(cv_cct) AS escuelas,SUM(V1418) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".esp_cam_".$ini_ciclo." 
                        WHERE (cv_estatus_captura = 0) ".$filtro." ;";
                        //echo $qr_especial_pree;
        $consulta=$qr_especial_pree;
    }
    if((strcmp($str_consulta,'especial_prim'))==0){
        $qr_especial_prim = "SELECT CONCAT('ESPECIAL_PRIMARIA') AS titulo_fila,
                        SUM(V1506+V1508+V1507+V1509) AS total_matricula,SUM(V1506+V1508) AS mat_hombres,SUM(V1507+V1509) AS mat_mujeres,
                        SUM(V2496) AS total_docentes,SUM(V2302) AS doc_hombres,SUM(V2303) AS doc_mujeres,
                        COUNT(cv_cct) AS escuelas,SUM(V1511) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".esp_cam_".$ini_ciclo." 
                        WHERE (cv_estatus_captura = 0) ".$filtro." ;";
                        //echo $qr_especial_prim;
        $consulta=$qr_especial_prim;
    }
    if((strcmp($str_consulta,'especial_sec'))==0){
        $qr_especial_sec = "SELECT CONCAT('ESPECIAL_SECUNDARIA') AS titulo_fila,
                        SUM(V1581+V1583+V1582+V1584) AS total_matricula,SUM(V1581+V1583) AS mat_hombres,SUM(V1582+V1584) AS mat_mujeres,
                        SUM(V2496) AS total_docentes,SUM(V2302) AS doc_hombres,SUM(V2303) AS doc_mujeres,
                        COUNT(cv_cct) AS escuelas,SUM(V1586) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".esp_cam_".$ini_ciclo." 
                        WHERE (cv_estatus_captura = 0) ".$filtro." ;";
                        //echo $qr_especial_sec;
        $consulta=$qr_especial_sec;
    }
    if((strcmp($str_consulta,'especial_ftrab'))==0){
        $qr_especial_ftrab = "SELECT CONCAT('ESPECIAL_FTRAB') AS titulo_fila,
                        SUM(V1760+V1762+V1761+V1763) AS total_matricula,SUM(V1760+V1762) AS mat_hombres,SUM(V1761+V1763) AS mat_mujeres,
                        SUM(V2496) AS total_docentes,SUM(V2302) AS doc_hombres,SUM(V2303) AS doc_mujeres,
                        COUNT(cv_cct) AS escuelas,SUM(V1765) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".esp_cam_".$ini_ciclo." 
                        WHERE (cv_estatus_captura = 0) ".$filtro." ;";
                        //echo $qr_especial_ftrab;
        $consulta=$qr_especial_ftrab;
    }
    if((strcmp($str_consulta,'especial_apoyo'))==0){
        $qr_especial_apoyo = "SELECT CONCAT('ESPECIAL_APOYO') AS titulo_fila,
                        SUM(V1887+V1889+V1888+V1890) AS total_matricula,SUM(V1887+V1889) AS mat_hombres,SUM(V1888+V1890) AS mat_mujeres,
                        SUM(V2496) AS total_docentes,SUM(V2302) AS doc_hombres,SUM(V2303) AS doc_mujeres,
                        COUNT(cv_cct) AS escuelas,SUM(0) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".esp_cam_".$ini_ciclo." 
                        WHERE (cv_estatus_captura = 0) ".$filtro." ;";
                        //echo $qr_especial_apoyo;
        $consulta=$qr_especial_apoyo;
    }
    if((strcmp($str_consulta,'especial_usaer'))==0){
        $qr_especial_usaer = "SELECT CONCAT('ESPECIAL_USAER') AS titulo_fila,
                        SUM(v2827) AS total_matricula,SUM(V2814+V2816+V2818+V2820) AS mat_hombres,SUM(V2815+V2817+V2819+V2821) AS mat_mujeres,
                        SUM(v2828+V2973+V2974) AS total_docentes,SUM(V2973) AS doc_hombres,SUM(V2974) AS doc_mujeres,
                        COUNT(cv_cct) AS escuelas,SUM(0) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".esp_usaer_".$ini_ciclo." 
                        WHERE (cv_estatus_captura = 0 OR cv_estatus_captura = 10) ".$filtro." ;";
                        //echo $qr_especial_usaer;
        $consulta=$qr_especial_usaer;
    }
    if((strcmp($str_consulta,'especial_usaer_doc'))==0){
        $qr_especial_usaer_doc = "SELECT CONCAT('ESPECIAL_USAER') AS titulo_fila,
                        SUM(0) AS total_matricula,SUM(0) AS mat_hombres,SUM(0) AS mat_mujeres,
                        SUM(0) AS total_docentes,SUM(V2835) AS doc_hombres,SUM(V2836) AS doc_mujeres,
                        SUM(0) AS escuelas,SUM(0) AS grupos 
                        FROM nonce_pano_".$ini_ciclo.".esp_usaer_".$ini_ciclo." 
                        WHERE (cv_estatus_captura = 0 OR cv_estatus_captura = 10) AND v2828='1' ".$filtro." ;";
                        //echo $qr_especial_usaer_doc;
        $consulta=$qr_especial_usaer_doc;
    }
    
    return $consulta;
}
	
function arreglos_datos($tipo_tabla,$link,$ini_ciclo,$filtro_extra,$filtro_pub,$filtro_priv){
    
    //INICIAL (ESCOLARIZADA)
        $total_gral_alum_ini=subnivel($link,"GENERAL ALUMNOS",$ini_ciclo,"gral_ini",$filtro_extra,$filtro_pub,$filtro_priv);
        $total_gral_dir_ini=subnivel($link,"GENERAL DIR CGRP",$ini_ciclo,"gral_ini_dir_grp",$filtro_extra,$filtro_pub,$filtro_priv);			
        $total_ind_ini=subnivel($link,"INDIGENA",$ini_ciclo,"ind_ini",$filtro_extra,$filtro_pub,$filtro_priv);
        $total_usbq_lac_ini=subnivel($link,"LACTANTES",$ini_ciclo,"lact_ini",$filtro_extra,$filtro_pub,$filtro_priv);
        $total_usbq_mat_ini=subnivel($link,"MATERNAL",$ini_ciclo,"mater_ini",$filtro_extra,$filtro_pub,$filtro_priv);
        
        //TOTALES (INICIAL)
        $total_gral_ini=acum_totales("NA","GENERAL INICIAL",$total_gral_alum_ini,$total_gral_dir_ini,subnivel_cero(),subnivel_cero());
        $total_ini=acum_totales("NA","EDUCACIÓN INICIAL",$total_gral_ini,$total_ind_ini,subnivel_cero(),subnivel_cero());

    //INICIAL (NO ESCOLARIZADA)
        if(((strcmp($ini_ciclo,'21'))==0)||((strcmp($ini_ciclo,'22'))==0)){
            echo "<BR>En este año no se contaba con inicial comunitaria";
            $total_sedeq_comuni_ini=subnivel_cero();
            $total_sedeq_ne_ini=subnivel_cero();
            $total_sedeq_nesc_ini=subnivel_cero();
        }else{
            $total_sedeq_comuni_ini=subnivel($link,"COMUNITARIO",$ini_ciclo,"comuni_ini",$filtro_extra,$filtro_pub,$filtro_priv);
            $total_sedeq_ne_ini=subnivel($link,"NE",$ini_ciclo,"ne_ini",$filtro_extra,$filtro_pub,$filtro_priv);
            $total_sedeq_nesc_ini=acum_totales("NA","INICIAL NE",$total_sedeq_comuni_ini,$total_sedeq_ne_ini,subnivel_cero(),subnivel_cero());
        }

    //CAM
        $total_usbq_esp_ini=subnivel($link,"INICIAL",$ini_ciclo,"especial_ini",$filtro_extra,$filtro_pub,$filtro_priv);
        $total_usbq_esp_pree=subnivel($link,"INICIAL",$ini_ciclo,"especial_pree",$filtro_extra,$filtro_pub,$filtro_priv);
        $total_usbq_esp_prim=subnivel($link,"INICIAL",$ini_ciclo,"especial_prim",$filtro_extra,$filtro_pub,$filtro_priv);
        $total_usbq_esp_sec=subnivel($link,"INICIAL",$ini_ciclo,"especial_sec",$filtro_extra,$filtro_pub,$filtro_priv);
        $total_usbq_esp_ftrab=subnivel($link,"INICIAL",$ini_ciclo,"especial_ftrab",$filtro_extra,$filtro_pub,$filtro_priv);
        $total_usbq_esp_apoyo=subnivel($link,"INICIAL",$ini_ciclo,"especial_apoyo",$filtro_extra,$filtro_pub,$filtro_priv);
        $total_usbq_esp_total=subnivel($link,"INICIAL",$ini_ciclo,"especial_tot",$filtro_extra,$filtro_pub,$filtro_priv);
        
    //USAER
        $sedeq_esp_usaer=subnivel($link,"ALUMNOS ESPECIAL (USAER)",$ini_ciclo,"especial_usaer",$filtro_extra,$filtro_pub,$filtro_priv);
        $sedeq_esp_usaer_doc=subnivel($link,"DOCENTES ESPECIAL (USAER)",$ini_ciclo,"especial_usaer_doc",$filtro_extra,$filtro_pub,$filtro_priv);
        $total_sedeq_esp_usaer=acum_totales("NA","ESPECIAL (USAER)",$sedeq_esp_usaer,$sedeq_esp_usaer_doc,subnivel_cero(),subnivel_cero());
            
    //PREESCOLAR
        $total_gral_pree=subnivel($link,"GENERAL",$ini_ciclo,"gral_pree",$filtro_extra,$filtro_pub,$filtro_priv);
        $total_ini1ro=subnivel($link,"INI1ro",$ini_ciclo,"ini_1ro_pree",$filtro_extra,$filtro_pub,$filtro_priv);
        $total_ind_pree=subnivel($link,"INDIGENA",$ini_ciclo,"ind_pree",$filtro_extra,$filtro_pub,$filtro_priv);
        $total_comuni_pree=subnivel($link,"COMUNITARIO",$ini_ciclo,"comuni_pree",$filtro_extra,$filtro_pub,$filtro_priv);
        
        //TOTALES (PREESCOLAR)
        $total_pree_gral=acum_totales("NA","GENERAL",$total_gral_pree,$total_ini1ro,subnivel_cero(),subnivel_cero());
        $total_pree=acum_totales("NA","EDUCACIÓN PREESCOLAR",$total_gral_pree,$total_ind_pree,$total_comuni_pree,$total_ini1ro);
    
    //PRIMARIA
        $total_gral_prim=subnivel($link,"GENERAL",$ini_ciclo,"gral_prim",$filtro_extra,$filtro_pub,$filtro_priv);
        $total_ind_prim=subnivel($link,"INDIGENA",$ini_ciclo,"ind_prim",$filtro_extra,$filtro_pub,$filtro_priv);
        $total_comuni_prim=subnivel($link,"COMUNITARIO",$ini_ciclo,"comuni_prim",$filtro_extra,$filtro_pub,$filtro_priv);
        
        //TOTALES (PRIMARIA)
        $total_prim=acum_totales("NA","EDUCACIÓN PRIMARIA",$total_gral_prim,$total_ind_prim,$total_comuni_prim,subnivel_cero());
    
    //SECUNDARIA
        $total_gral_sec=subnivel($link,"GENERAL",$ini_ciclo,"gral_sec",$filtro_extra,$filtro_pub,$filtro_priv);
        $total_comuni_sec=subnivel($link,"COMUNITARIO",$ini_ciclo,"comuni_sec",$filtro_extra,$filtro_pub,$filtro_priv);
        $total_subn_gral_sec=subnivel($link,"GENERAL",$ini_ciclo,"sec_gral_gral",$filtro_extra,$filtro_pub,$filtro_priv);
        $total_tele_sec=subnivel($link,"TELESECUNDARIA",$ini_ciclo,"sec_gral_tele",$filtro_extra,$filtro_pub,$filtro_priv);
        $total_tec_sec=subnivel($link,"TECNICA",$ini_ciclo,"sec_gral_tec",$filtro_extra,$filtro_pub,$filtro_priv); 
        
        //TOTALES (SECUNDARIA)
        $total_sec_gral=acum_totales("NA","GENERAL",$total_subn_gral_sec,$total_comuni_sec,subnivel_cero(),subnivel_cero());
        $total_sec=acum_totales("NA","EDUCACIÓN SECUNDARIA",$total_gral_sec,$total_comuni_sec,subnivel_cero(),subnivel_cero());
        $total_usbq_sec=acum_totales("NA","EDUCACIÓN SECUNDARIA",$total_subn_gral_sec,$total_tec_sec,$total_tele_sec,$total_comuni_sec);

    //MEDIA SUPERIOR 
        $mod_msup=" AND (c_modalidad='ESCOLARIZADA' OR c_modalidad='MIXTA') ";
        $mod_nesc_msup=" AND (c_modalidad<>'ESCOLARIZADA' AND c_modalidad<>'MIXTA') ";
        
        //ESCOLARIZADA (MEDIA SUPERIOR)
        $total_esc_btecno_msup=subnivel($link,"BACHILLERATO TECNOLOGICO TOT",$ini_ciclo,"btecno_msup",$mod_msup." ".$filtro_extra,$filtro_pub." ".$mod_msup,$filtro_priv." ".$mod_msup);
        $total_esc_bgral_msup=subnivel($link,"BACHILLERATO GENERAL",$ini_ciclo,"bgral_msup",$mod_msup." ".$filtro_extra,$filtro_pub." ".$mod_msup,$filtro_priv." ".$mod_msup);
        $total_esc_btecno_tecno_msup=subnivel($link,"BACHILLERATO TECNOLOGICO",$ini_ciclo,"btecno_tecno_msup",$mod_msup." ".$filtro_extra,$filtro_pub." ".$mod_msup,$filtro_priv." ".$mod_msup);
        $total_esc_pbach_msup=subnivel($link,"PROFESIONAL TECNICO BACHILLER",$ini_ciclo,"btecno_pbach_msup",$mod_msup." ".$filtro_extra,$filtro_pub." ".$mod_msup,$filtro_priv." ".$mod_msup);
        $total_esc_ptecno_msup=subnivel($link,"PROFESIONAL TECNICO",$ini_ciclo,"btecno_ptecno_msup",$mod_msup." ".$filtro_extra,$filtro_pub." ".$mod_msup,$filtro_priv." ".$mod_msup);
        $total_esc_msup=acum_totales("NA","EDUCACIÓN MEDIA SUPERIOR",$total_esc_bgral_msup,$total_esc_btecno_msup,subnivel_cero(),subnivel_cero());
        $total_usbq_esc_btecno_msup=acum_totales("NA","BACHILLERATO TECNOLOGICO",$total_esc_btecno_tecno_msup,$total_esc_pbach_msup,subnivel_cero(),subnivel_cero());
        
        //NO ESCOLARIZADA (MEDIA SUPERIOR)
        $total_nesc_btecno_msup=subnivel($link,"BACHILLERATO TECNOLOGICO TOT",$ini_ciclo,"btecno_msup",$mod_nesc_msup." ".$filtro_extra,$filtro_pub." ".$mod_nesc_msup,$filtro_priv." ".$mod_nesc_msup);
        $total_nesc_bgral_msup=subnivel($link,"BACHILLERATO GENERAL",$ini_ciclo,"bgral_msup",$mod_nesc_msup." ".$filtro_extra,$filtro_pub." ".$mod_nesc_msup,$filtro_priv." ".$mod_nesc_msup);
        $total_nesc_btecno_tecno_msup=subnivel($link,"BACHILLERATO TECNOLOGICO",$ini_ciclo,"btecno_tecno_msup",$mod_nesc_msup." ".$filtro_extra,$filtro_pub." ".$mod_nesc_msup,$filtro_priv." ".$mod_nesc_msup);
        $total_nesc_pbach_msup=subnivel($link,"PROFESIONAL TECNICO BACHILLER",$ini_ciclo,"btecno_pbach_msup",$mod_nesc_msup." ".$filtro_extra,$filtro_pub." ".$mod_nesc_msup,$filtro_priv." ".$mod_nesc_msup);
        $total_nesc_ptecno_msup=subnivel($link,"PROFESIONAL TECNICO",$ini_ciclo,"btecno_ptecno_msup",$mod_nesc_msup." ".$filtro_extra,$filtro_pub." ".$mod_nesc_msup,$filtro_priv." ".$mod_nesc_msup);
        $total_nesc_msup=acum_totales("NA","EDUCACIÓN MEDIA SUPERIOR",$total_nesc_bgral_msup,$total_nesc_btecno_msup,subnivel_cero(),subnivel_cero());
        $total_usbq_nesc_btecno_msup=acum_totales("NA","BACHILLERATO TECNOLOGICO",$total_nesc_btecno_tecno_msup,$total_nesc_pbach_msup,subnivel_cero(),subnivel_cero());
    

        // TOTALES (MEDIA SUPERIOR)
        $total_msup=acum_totales("NA","EDUCACIÓN MEDIA SUPERIOR",$total_esc_msup,$total_nesc_msup,subnivel_cero(),subnivel_cero());
        $total_bgral_msup=acum_totales("NA","BACHILLERATO GENERAL",$total_esc_bgral_msup,$total_nesc_bgral_msup,subnivel_cero(),subnivel_cero());
        $total_btecno_tecno_msup=acum_totales("NA","BACHILLERATO TECNOLOGICO",$total_esc_btecno_tecno_msup,$total_nesc_btecno_tecno_msup,subnivel_cero(),subnivel_cero());
        $total_pbach_msup=acum_totales("NA","PROFESIONAL TECNICO BACHILLER",$total_esc_pbach_msup,$total_nesc_pbach_msup,subnivel_cero(),subnivel_cero());
        $total_ptecno_msup=acum_totales("NA","PROFESIONAL TECNICO",$total_esc_ptecno_msup,$total_nesc_ptecno_msup,subnivel_cero(),subnivel_cero());
        $total_usbq_btecno_msup=acum_totales("NA","BACHILLERATO TECNOLOGICO",$total_usbq_esc_btecno_msup,$total_usbq_nesc_btecno_msup,subnivel_cero(),subnivel_cero());
        $total_usbq_escuelas_msup=subnivel($link,"ESCUELAS MEDIA SUPERIOR",$ini_ciclo,"plant_doc_esc_msup",$filtro_extra,$filtro_pub,$filtro_priv);
        $total_usbq_msup=acum_totales("DIF_DOCENTES","EDUCACIÓN MEDIA SUPERIOR",$total_usbq_escuelas_msup,$total_msup,subnivel_cero(),subnivel_cero());
        $sedeq_doc_plant_msup=subnivel($link,"DOCENTES MSUP",$ini_ciclo,"plant_doc_esc_msup",$filtro_extra,$filtro_pub,$filtro_priv);
        $total_sedeq_msup=juntar_msup("DOCENTES MSUP",$total_msup,$sedeq_doc_plant_msup);
        
        

        $total_btecno_msup=acum_totales("NA","BACHILLERATO TECNOLOGICO TOT",$total_esc_btecno_msup,$total_nesc_btecno_msup,subnivel_cero(),subnivel_cero());
        
    
    //SUPERIOR 
        $mod_sup=" AND c_modalidad='ESCOLARIZADA' ";
        $mod_nesc_sup=" AND c_modalidad<>'ESCOLARIZADA' ";
    
        //ESCOLARIZADA (SUPERIOR)
        $total_esc_lic_sup=mezcla_arreglos("AMBOS","LICENCIATURA","carr_lic_sup","esc_lic_sup","LICENCIATURA","LICENCIATURA2",$link,$ini_ciclo,$mod_sup." ".$filtro_extra,$filtro_pub,$filtro_priv);
        $total_esc_normal_sup=mezcla_arreglos("AMBOS","NORMAL","carr_normal_sup","esc_normal_sup","NORMAL","NORMAL2",$link,$ini_ciclo,$mod_sup." ".$filtro_extra,$filtro_pub,$filtro_priv);
        $total_esc_tecno_sup=mezcla_arreglos("AMBOS","UNIVERSITARIA Y TECNOLOGICA","carr_tecno_sup","esc_tecno_sup","UNIVERSITARIA Y TECNOLOGICA","UNIVERSITARIA Y TECNOLOGICA2",$link,$ini_ciclo,$mod_sup." ".$filtro_extra,$filtro_pub,$filtro_priv);
        $total_esc_posg_sup=mezcla_arreglos("AMBOS","POSGRADO","posgr_sup","esc_posgr_sup","POSGRADO","POSGRADO2",$link,$ini_ciclo,$mod_sup." ".$filtro_extra,$filtro_pub,$filtro_priv);
        $total_esc_comb_sup=mezcla_arreglos("AMBOS","EDUCACIÓN SUPERIOR","carr_lic_sup","esc_carr_doc_sup","SUPERIOR","SUPERIOR2",$link,$ini_ciclo,$mod_sup." ".$filtro_extra,$filtro_pub,$filtro_priv);
        $total_esc_sup=acum_totales("DIF_AMBOS","EDUCACIÓN SUPERIOR",$total_esc_comb_sup,$total_esc_posg_sup,subnivel_cero(),subnivel_cero());
        
        //NO ESCOLARIZADA (SUPERIOR)
        $total_nesc_lic_sup=mezcla_arreglos("AMBOS","LICENCIATURA","carr_lic_sup","esc_nesc_lic_sup","LICENCIATURA","LICENCIATURA2",$link,$ini_ciclo,$mod_nesc_sup." ".$filtro_extra,$filtro_pub,$filtro_priv);
        $total_nesc_normal_sup=mezcla_arreglos("AMBOS","NORMAL","carr_normal_sup","esc_nesc_normal_sup","NORMAL","NORMAL2",$link,$ini_ciclo,$mod_nesc_sup." ".$filtro_extra,$filtro_pub,$filtro_priv);
        $total_nesc_tecno_sup=mezcla_arreglos("AMBOS","UNIVERSITARIA Y TECNOLOGICA","carr_tecno_sup","esc_nesc_tecno_sup","UNIVERSITARIA Y TECNOLOGICA","UNIVERSITARIA Y TECNOLOGICA2",$link,$ini_ciclo,$mod_nesc_sup." ".$filtro_extra,$filtro_pub,$filtro_priv);
        $total_nesc_posg_sup=mezcla_arreglos("AMBOS","POSGRADO","posgr_sup","esc_nesc_posgr_sup","POSGRADO","POSGRADO2",$link,$ini_ciclo,$mod_nesc_sup." ".$filtro_extra,$filtro_pub." ".$filtro_extra,$filtro_priv);
        $total_nesc_comb_sup=mezcla_arreglos("AMBOS","EDUCACIÓN SUPERIOR","carr_lic_sup","esc_nesc_sup","SUPERIOR","SUPERIOR2",$link,$ini_ciclo,$mod_nesc_sup." ".$filtro_extra,$filtro_pub." ".$filtro_extra,$filtro_priv);
        $total_nesc_sup=acum_totales("DIF_AMBOS","EDUCACIÓN SUPERIOR",$total_nesc_comb_sup,$total_nesc_posg_sup,subnivel_cero(),subnivel_cero());
        
        //TOTALES (SUPERIOR)
        $total_lic_sup=acum_totales("NA","LICENCIATURA",$total_esc_lic_sup,$total_nesc_lic_sup,subnivel_cero(),subnivel_cero());
        $total_normal_sup=acum_totales("NA","NORMAL",$total_esc_normal_sup,$total_nesc_normal_sup,subnivel_cero(),subnivel_cero());
        $total_tecno_sup=acum_totales("NA","UNIVERSITARIA Y TECNOLOGICA",$total_esc_tecno_sup,$total_nesc_tecno_sup,subnivel_cero(),subnivel_cero());
        $total_posg_sup=acum_totales("NA","POSGRADO",$total_esc_posg_sup,$total_nesc_posg_sup,subnivel_cero(),subnivel_cero());
        $total_sup=acum_totales("NA","EDUCACIÓN SUPERIOR",$total_esc_sup,$total_nesc_sup,subnivel_cero(),subnivel_cero());
        
        $total_usbq_tsu_sup=mezcla_arreglos("AMBOS","TECNICO SUPERIOR","carr_usbq_tsu_sup","esc_lic_sup","LICENCIATURA","LICENCIATURA2",$link,$ini_ciclo,$filtro_extra,$filtro_pub,$filtro_priv);
        $total_usbq_lic_sup=mezcla_arreglos("AMBOS","TECNICO SUPERIOR","carr_usbq_lic_sup","esc_lic_sup","LICENCIATURA","LICENCIATURA2",$link,$ini_ciclo,$filtro_extra,$filtro_pub,$filtro_priv);
        $total_usbq_docentes_sup=subnivel($link,"DOCENTES",$ini_ciclo,"esc_docentes_sup",$filtro_extra,$filtro_pub,$filtro_priv);
        $total_usbq_sup=acum_totales("DIF_AMBOS","EDUCACIÓN SUPERIOR",$total_usbq_docentes_sup,$total_sup,subnivel_cero(),subnivel_cero());
            
        $total_sedeq_doc_munic_sup=subnivel($link,"DOCENTES",$ini_ciclo,"esc_sedeq_doc_munic_sup",$filtro_extra,$filtro_pub,$filtro_priv);
        $total_sedeq_munic_sup=acum_totales("DIF_AMBOS","EDUCACIÓN SUPERIOR",$total_sedeq_doc_munic_sup,$total_sup,subnivel_cero(),subnivel_cero());
        
        
        $total_sedeq_docentes_sup=subnivel($link,"DOCENTES",$ini_ciclo,"esc_sedeq_docentes_sup",$filtro_extra,$filtro_pub,$filtro_priv);
        $total_sedeq_sup=acum_totales("DIF_AMBOS","EDUCACIÓN SUPERIOR",$total_sedeq_docentes_sup,$total_sup,subnivel_cero(),subnivel_cero());
        
        
        if((strcmp($filtro_extra,' '))==0){
            $total_sedeq_munic_unidades_sup=subnivel_cero();
        }else{
            $unidades_sedeq_sup=subnivel($link,"UNIDADES SUPERIOR",$ini_ciclo,"unidades_sup",$filtro_extra,$filtro_pub,$filtro_priv);

            $cantidad_vacios=0;
            if((strcmp($unidades_sedeq_sup["tot_mat"],''))==0){
                $cantidad_vacios=$cantidad_vacios+1;
            }
            if((strcmp($unidades_sedeq_sup["tot_doc"],''))==0){
                $cantidad_vacios=$cantidad_vacios+1;
            }
            if((strcmp($unidades_sedeq_sup["tot_esc"],''))==0){
                $cantidad_vacios=$cantidad_vacios+1;
            }
            if((strcmp($unidades_sedeq_sup["tot_grp"],''))==0){
                $cantidad_vacios=$cantidad_vacios+1;
            }
            if($cantidad_vacios>2){
                $unidades_sedeq_sup=subnivel_cero();
            }
            $total_sedeq_munic_unidades_sup=acum_unidades($link,$ini_ciclo,$filtro_pub,$filtro_priv,$filtro_extra,"EDUCACIÓN SUPERIOR UNIDADES",$total_sedeq_sup,$unidades_sedeq_sup);
        }

    
        //$total_comb_sup=acum_totales("NA","EDUCACIÓN SUPERIOR",$total_esc_comb_sup,$total_nesc_comb_sup,subnivel_cero(),subnivel_cero());
        
        
        
    
    //TOTALES SISTEMA
    
        //ACUM TABLA CIFRAS
        $total_basica=acum_totales("NA","EDUCACIÓN BASICA",$total_ini,$total_pree,$total_prim,$total_sec);
        $total_escolarizada=acum_totales("NA","MODALIDAD ESCOLARIZADA",$total_basica,$total_esc_msup,$total_esc_sup,subnivel_cero());
        $total_nesc=acum_totales("NA","MODALIDAD NO ESCOLARIZADA",$total_nesc_msup,$total_nesc_sup,subnivel_cero(),subnivel_cero());
        $total_sistema=acum_totales("NA","TOTAL DEL SISTEMA EDUCATIVO",$total_escolarizada,$total_nesc,subnivel_cero(),subnivel_cero());
        
        //ACUM TABLA USBQ
        $total_usbq_basica=acum_totales("NA","EDUCACIÓN BASICA",$total_ini,$total_pree,$total_prim,$total_usbq_sec);
        $total_usbq_sistema=acum_totales("NA","TOTAL SISTEMA",$total_usbq_esp_total,$total_usbq_basica,$total_usbq_msup,$total_usbq_sup);
        
        /* $sedeq_basica_s1=acum_totales("NA","INICIAL Y CAM",$total_ini,$total_sedeq_nesc_ini,$total_usbq_esp_total,subnivel_cero());
        $total_sedeq_basica=acum_totales("NA","EDUCACIÓN BASICA",$sedeq_basica_s1,$total_pree,$total_prim,$total_sec);
        $total_sedeq_sistema=acum_totales("NA","EDUCACIÓN BASICA",$total_sedeq_basica,$total_sedeq_msup,$total_sup,subnivel_cero()); */
        
        $subtotal_sedeq_sistema_sec1=acum_totales("NA","INICIAL",$total_ini,$total_sedeq_nesc_ini,subnivel_cero(),subnivel_cero());
        $subtotal_sedeq_sistema_sec2=acum_totales("USAER","CAM + USAER",$total_usbq_esp_total,$total_sedeq_esp_usaer,subnivel_cero(),subnivel_cero());
        $subtotal_sedeq_sistema_sec3=acum_totales("NA","BASICA",$subtotal_sedeq_sistema_sec1,$total_pree,$total_prim,$total_sec);
        $total_sedeq_sistema=acum_totales("NA","BASICA + MEDIA + SUPERIOR",$subtotal_sedeq_sistema_sec2,$subtotal_sedeq_sistema_sec3,$total_sedeq_msup,$total_sedeq_sup);
        //$total_sedeq_sistema=acum_totales("NA","prueba",$total_usbq_esp_total,subnivel_cero(),subnivel_cero(),subnivel_cero());
    

}

?>