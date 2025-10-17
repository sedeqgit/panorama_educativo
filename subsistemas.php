function matSubSostenimiento($link,$tabla_ms_plantel,$tabla_ms_gral,$tabla_ms_tecno){
		$sum_inba=0;
		$sum_dgetis=0;
		$sum_dgb=0;
		$sum_particular=0;
		$sum_abierta=0;
		$sum_conalep=0;
		$sum_dgetaycm=0;
		$sum_iebas=0;
		$sum_cobach=0;
		$sum_emsad=0;
		$sum_cecyte=0;
		$sum_tbc=0;
		$sum_auton=0;
		//cv_motivo!=7 Escuelas no activas (no incluidas en directorios y todas las variables en 0 en el 911)
		$qr_esc_sub_sost = "SELECT COUNT(DISTINCT cct_ins_pla)as total_escuelas, 
							SUM(v62) as total_alumnos,cct_ins_pla as id_escuela
							FROM ".$tabla_ms_plantel." 
							WHERE cv_motivo!=7 
							GROUP BY cct_ins_pla ORDER BY total_alumnos DESC ;";
							//echo $qr_esc_sub_sost."<br>";
		$rs_esc_sub_sost = pg_query($link,$qr_esc_sub_sost) or die('La consulta qr_esc_sub_sost: ' . pg_last_error());

		while ($row_esc_sub_sost = pg_fetch_assoc($rs_esc_sub_sost)) {		
			$id_escuela=$row_esc_sub_sost['id_escuela'];
			$total_alumnos=$row_esc_sub_sost['total_alumnos'];
			//echo $id_escuela."-";
			$qr_bgral_sub = "SELECT subsistema_2 as subsistema
				FROM ".$tabla_ms_gral." 
				WHERE cct_ins_pla='".$id_escuela."';";
				//echo $qr_bgral_sub."<br>";
			$rs_bgral_sub = pg_query($link,$qr_bgral_sub) or die('La consulta qr_bgral_sub: ' . pg_last_error());
			$cant_bgral_sub=pg_num_rows($rs_bgral_sub);
			$row_bgral_sub = pg_fetch_assoc($rs_bgral_sub);
			if($cant_bgral_sub>0){
				$subsistema=$row_bgral_sub['subsistema'];
			}else{
				$qr_btecno_sub = "SELECT subsistema_2 as subsistema
				FROM ".$tabla_ms_tecno." 
				WHERE cct_ins_pla='".$id_escuela."';";
				//echo $qr_bgral_sub."<br>";
				$rs_btecno_sub = pg_query($link,$qr_btecno_sub) or die('La consulta qr_btecno_sub: ' . pg_last_error());
				$cant_btecno_sub=pg_num_rows($rs_btecno_sub);
				$row_btecno_sub = pg_fetch_assoc($rs_btecno_sub);
				if($cant_btecno_sub>0){
					$subsistema=$row_btecno_sub['subsistema'];
				}else{
					$subsistema="";
				}
			} 

			if((strcmp($subsistema,"EMSAD"))==0){
				$sum_emsad=$sum_emsad+$total_alumnos;
			}
			if((strcmp($subsistema,"PREPA ABIERTA ESTATAL"))==0){
				$sum_abierta=$sum_abierta+$total_alumnos;
			}
			if((strcmp($subsistema,"COBACH"))==0){
				$sum_cobach=$sum_cobach+$total_alumnos;
			}
			if((strcmp($subsistema,"INBA"))==0){
				$sum_inba=$sum_inba+$total_alumnos;
			}
			if((strcmp($subsistema,"DGETIS"))==0){
				$sum_dgetis=$sum_dgetis+$total_alumnos;
			}
			if((strcmp($subsistema,"DGB"))==0){
				$sum_dgb=$sum_dgb+$total_alumnos;
			}
			if((strcmp($subsistema,"PARTICULAR"))==0){
				$sum_particular=$sum_particular+$total_alumnos;
			}
			
			if((strcmp($subsistema,"CONALEP"))==0){
				$sum_conalep=$sum_conalep+$total_alumnos;
			}
			if((strcmp($subsistema,"DGETAyCM"))==0){
				$sum_dgetaycm=$sum_dgetaycm+$total_alumnos;
			}
			if((strcmp($subsistema,"IEBAS"))==0){
				$sum_iebas=$sum_iebas+$total_alumnos;
			}
			
			
			if((strcmp($subsistema,"CECYTE"))==0){
				$sum_cecyte=$sum_cecyte+$total_alumnos;
			}
			if((strcmp($subsistema,"TELEBACHILLERATO COMUNITARIO"))==0){
				$sum_tbc=$sum_tbc+$total_alumnos;
			}
			if((strcmp($subsistema,"UNIVERSIDADES AUTONOMAS ESTATALES"))==0){
				$sum_auton=$sum_auton+$total_alumnos;
			}
			
		}

		$sum_cobach=$sum_cobach+$sum_emsad+$sum_abierta;
		/**
		echo "sum_cobach ".$sum_cobach."<br>";
		echo "sum_cecyte ".$sum_cecyte."<br>";
		echo "sum_conalep ".$sum_conalep."<br>";
		echo "sum_tbc ".$sum_tbc."<br>";
		echo "sum_iebas(CENADART) ".$sum_iebas."<br>";
		echo "sum_auton ".$sum_auton."<br>";
		echo "sum_dgetis ".$sum_dgetis."<br>";
		echo "sum_dgetaycm ".$sum_dgetaycm."<br>";
		echo "sum_inba(CEDART) ".$sum_inba."<br>";
		echo "sum_dgb(CAED) ".$sum_dgb."<br>";
		echo "sum_particular ".$sum_particular."<br>";
		
		echo "sum_abierta ".$sum_abierta."<br>";
		echo "sum_emsad ".$sum_emsad."<br>";
		*/
		echo "<TABLE border=1>";
			echo "<TR>";
				echo "<TD>SUBSISTEMA</TD><TD>ALUMNOS</TD>";
			echo "</TR>";
			echo "<TR>";
				echo "<TD>COBAQ</TD><TD>".$sum_cobach."</TD>";
			echo "</TR>";
			echo "<TR>";
				echo "<TD>CECYTEQ</TD><TD>".$sum_cecyte."</TD>";
			echo "</TR>";
			echo "<TR>";
				echo "<TD>CONALEP</TD><TD>".$sum_conalep."</TD>";
			echo "</TR>";
			echo "<TR>";
				echo "<TD>TELEBACHILLERATO</TD><TD>".$sum_tbc."</TD>";
			echo "</TR>";
			echo "<TR>";
				echo "<TD>CENADART</TD><TD>".$sum_iebas."</TD>";
			echo "</TR>";
			echo "<TR>";
				echo "<TD>UAQ</TD><TD>".$sum_auton."</TD>";
			echo "</TR>";
			echo "<TR>";
				echo "<TD>DGETIS</TD><TD>".$sum_dgetis."</TD>";
			echo "</TR>";
			echo "<TR>";
				echo "<TD>DGETAyCM</TD><TD>".$sum_dgetaycm."</TD>";
			echo "</TR>";
			echo "<TR>";
				echo "<TD>CEDART</TD><TD>".$sum_inba."</TD>";
			echo "</TR>";
			echo "<TR>";
				echo "<TD>CAED</TD><TD>".$sum_dgb."</TD>";
			echo "</TR>";
			echo "<TR>";
				echo "<TD>PRIVADO</TD><TD>".$sum_particular."</TD>";
			echo "</TR>";
		echo "</TABLE>";

	}
