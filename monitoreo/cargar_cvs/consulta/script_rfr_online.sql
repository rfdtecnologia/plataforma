DELETE FROM AUX_CARGA_CUC_PASS01 WHERE ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

DELETE FROM AUX_CARGA_CUC_PASS02 WHERE ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		1		RUBRO_ID, 
		cc	CC_ID, 
		saldo_numerico, 
		case 
		when CC in ('5104','5201') then saldo_numerico
		else 0
		end,
		0
from 		C_CUC_CARGA 
where 	CC in ('5104','5201') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		2, 
		cc, 
		saldo_numerico, 
		case 
		when CC in ('52','54') then saldo_numerico
		else 0
		end,
		case 
		when CC in ('5201') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC in ('52','5201','54') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		3, 
		cc, 
		saldo_numerico, 
		case 
		when CC in ('51','53','5501') then saldo_numerico
		else 0
		end,
		case 
		when CC in ('5104') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC in ('51','5104','53','5501') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		4, 
		cc, 
		saldo_numerico, 
		case 
		when CC in ('55','560405','560420','560410') then saldo_numerico
		else 0
		end,
		case 
		when CC in ('5501') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC in ( '55','5501','560405','560420','560410') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		5, 
		cc, 
		saldo_numerico, 
		case 
		when CC in ('5') then saldo_numerico
		else 0
		end,
		case 
		when CC in ('5601','5602','5603','5690','560415') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC in ('5','5601','5602','5603','5690','560415') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		6, 
		cc, 
		saldo_numerico, 
		case 
		when CC IN ('41','4201','4202') then saldo_numerico
		end,
		0
from 		C_CUC_CARGA 
where 	CC IN ('41','4201','4202') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		7, 
		cc, 
		saldo_numerico, 
		case 
		when CC IN ( '4402') then saldo_numerico
		end,
		0
from 		C_CUC_CARGA 
where 	CC IN ( '4402') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		8, 
		cc, 
		saldo_numerico, 
		case 
		when CC IN ( '4501','4810') then saldo_numerico
		end,
		0
from 		C_CUC_CARGA 
where 	CC IN ( '4501','4810') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		9, 
		cc, 
		saldo_numerico, 
		case 
		when  CC IN ( '4502', '4503', '4504', '4505', '4506', '4507', '4890') then saldo_numerico
		end,
		0
from 		C_CUC_CARGA 
where 	CC IN ( '4502', '4503', '4504', '4505', '4506', '4507', '4890') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		10, 
		cc, 
		saldo_numerico, 
		case 
		when CC in ('42','43','44','46','4703') then saldo_numerico
		else 0 end,
		case 
		when CC in ('4201','4202','4402') then saldo_numerico 
		else 0 end
from 		C_CUC_CARGA 
where 	CC IN ('42','43','44','46','4703','4201','4202','4402') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		11, 
		cc, 
		saldo_numerico, 
		case 
		when CC in ('4') then saldo_numerico
		else 0 end,
		case 
		when CC in ('4701','4702','4815','4790') then saldo_numerico 
		else 0 end
from 		C_CUC_CARGA 
where 	CC IN ('4','4701','4702','4815','4790') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		12, 
		cc, 
		saldo_numerico, 
		case 
		when CC in ('5','4701','4702','4815','4790') then saldo_numerico
		else 0
		end,
		case 
		when CC in ('5601','5602','5603','5690','560415','4') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC in ('5','4701','4702','4815','4790','5601','5602','5603','5690','560415','4') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		13, 
		cc, 
		saldo_numerico, 
		case 
		when CC in ('4815') then saldo_numerico
		else 0 end,
		0 saldo_numerico 
		
from 		C_CUC_CARGA 
where 	CC IN ( '4815') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		14, 
		cc, 
		saldo_numerico, 
		case 
		when CC in ('5','4701','4702','4815','4790') then saldo_numerico
		else 0
		end,
		case 
		when CC in ('5601','5602','5603','5690','560415','4','4815') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC in ('5','4701','4702','4815','4790','5601','5602','5603','5690','560415','4','4815') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		16, 
		cc, 
		saldo_numerico, 
		case 
		when CC in ('56') then saldo_numerico
		else 0 end,
		case 
		when CC in ('560405','560420','560410') then saldo_numerico 
		else 0 end
from 		C_CUC_CARGA 
where 	CC IN ( '56','560405','560420','560410') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		17, 
		cc, 
		saldo_numerico, 
		case 
		when CC in ('56') then saldo_numerico
		else 0 end,
		case 
		when CC in ('560405','560420','560410') then saldo_numerico 
		else 0 end
from 		C_CUC_CARGA 
where 	CC IN ( '56','560405','560420','560410') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		18, 
		cc, 
		saldo_numerico, 
		case 
		when CC in ('47') then saldo_numerico
		else 0 end,
		case 
		when CC in ('4703') then saldo_numerico 
		else 0 end
from 		C_CUC_CARGA 
where 	CC IN ( '47','4703') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		19, 
		cc, 
		saldo_numerico, 
		case 
		when CC in ('5','4701','4702','4815','4790','56','4703') then saldo_numerico
		else 0
		end,
		case 
		when CC in ('5601','5602','5603','5690','560415','4','4815','560405','560420','560410','47') then saldo_numerico
		else 0 end
from 		C_CUC_CARGA 
where 	CC IN ('5','4701','4702','4815','4790','56','4703','5601','5602','5603','5690','560415','4','4815','560405','560420','560410','47') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		20, 
		cc, 
		saldo_numerico, 
		case 
		when CC in ('11') then saldo_numerico
		else 0 end,
		case 
		when CC in ('110205') then saldo_numerico 
		else 0 end	
from 		C_CUC_CARGA 
where 	CC IN ( '11','110205') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		21, 
		cc, 
		saldo_numerico, 
		case 
		when CC in ('110205') then saldo_numerico
		else 0 end,
		0	saldo_numerico 
from 		C_CUC_CARGA 
where 	CC IN ('110205') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		308, 
		cc, 
		saldo_numerico, 
		case 
		when CC in ('130105','130205','130305','130405','130505','130605','130705','130150','130350','130550') then saldo_numerico
		else 0 end,
		0	saldo_numerico 
from 		C_CUC_CARGA 
where 	CC IN ('130105','130205','130305','130405','130505','130605','130705','130150','130350','130550') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		309, 
		cc, 
		saldo_numerico, 
		case 
		when CC in ('130110','130210','130310','130410','130510','130610','130155','130355','130555') then saldo_numerico
		else 0 end,
		0	saldo_numerico 
from 		C_CUC_CARGA 
where 	CC IN ('130110','130210','130310','130410','130510','130610','130155','130355','130555') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		310, 
		cc, 
		saldo_numerico, 
		case 
		when CC in ('130115','130215','130315','130415','130515','130615','130160','130360','130560') then saldo_numerico
		else 0 end,
		0	saldo_numerico 
from 		C_CUC_CARGA 
where 	CC IN ('130115','130215','130315','130415','130515','130615','130160','130360','130560') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		311, 
		cc, 
		saldo_numerico, 
		case 
		when CC in ('130120','130220','130320','130420','130520','130620','130165','130365','130565') then saldo_numerico
		else 0 end,
		0	saldo_numerico 
from 		C_CUC_CARGA 
where 	CC IN ('130120','130220','130320','130420','130520','130620','130165','130365','130565') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		312, 
		cc, 
		saldo_numerico, 
		case 
		when CC in ('130125','130225','130325','130425','130430','130525','130530','130535','130540','130625','130630','130635','130640','1307','130170','130370','130570','130575','130580','130585') then saldo_numerico
		else 0
		end,
		case
		when	CC in ('130705') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('130125','130225','130325','130425','130430','130525','130530','130535','130540','130625','130630','130635','130640','1307','130170','130370','130570','130575','130580','130585','130705') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		315, 
		cc, 
		saldo_numerico, 
		case 
		when CC in ('1399') then saldo_numerico
		else 0 end,
		0 saldo_numerico
from 		C_CUC_CARGA 
where 	CC IN ( '1399') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		22, 
		cc, 
		saldo_numerico, 
		case 
		when CC in ('13') then saldo_numerico
		else 0 end,
		0	saldo_numerico 
from 		C_CUC_CARGA 
where 	CC IN ('13') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		23, 
		cc, 
		saldo_numerico, 
		case 
		when CC in ('14') then saldo_numerico
		when CC in ('1499') then abs(saldo_numerico)
		else 0 end,
		0 saldo_numerico
from 		C_CUC_CARGA 
where 	CC IN ( '14','1499') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		24, 
		cc, 
		saldo_numerico, 
		case 
		when CC in ('1499') then saldo_numerico
		else 0 end,
		0 saldo_numerico
from 		C_CUC_CARGA 
where 	CC IN ( '1499') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		25, 
		cc, 
		saldo_numerico, 
		case 
		when CC in ('1603', '1604', '1615') then saldo_numerico
		else 0 end,
		0 saldo_numerico
from 		C_CUC_CARGA 
where 	CC IN  ('1603', '1604', '1615') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		26, 
		cc, 
		saldo_numerico, 
		case 
		when CC in ('12','15','16','17','19') then saldo_numerico
		else 0
		end,
		case
		when	CC in ('1603', '1604', '1615', '1901') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ( '12','15','16','17','19', '1603', '1604', '1615', '1901') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		27, 
		cc, 
		saldo_numerico, 
		case 
		when CC in ('1901') then saldo_numerico
		else 0 end,
		0	saldo_numerico 
from 		C_CUC_CARGA 
where 	CC IN ( '1901') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		28, 
		cc, 
		saldo_numerico, 
		case 
		when CC in ('18') then saldo_numerico
		else 0
		end,
		0
from 		C_CUC_CARGA 
where 	CC IN ( '18') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		29, 
		cc, 
		saldo_numerico, 
		case 
		when CC in ('1') then saldo_numerico
		else 0
		end,
		0
from 		C_CUC_CARGA 
where 	CC IN ( '1') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		30, 
		cc, 
		saldo_numerico, 
		case 
		when CC in ('2105') then saldo_numerico
		else 0
		end,
		0
from 		C_CUC_CARGA 
where 	CC IN ( '2105') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		31, 
		cc, 
		saldo_numerico, 
		case 
		when CC IN ( '2101', '2104') then saldo_numerico
		else 0
		end,
		0
from 		C_CUC_CARGA 
where 	CC IN ( '2101', '2104') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		198, 
		cc, 
		saldo_numerico, 
		case 
		when CC IN ( '210305') then saldo_numerico
		else 0
		end,
		0
from 		C_CUC_CARGA 
where 	CC IN ( '210305') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		199, 
		cc, 
		saldo_numerico, 
		case 
		when CC IN ( '210310') then saldo_numerico
		else 0
		end,
		0
from 		C_CUC_CARGA 
where 	CC IN ( '210310') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		200, 
		cc, 
		saldo_numerico, 
		case 
		when CC IN ( '210315','210320','210325','210330') then saldo_numerico
		else 0
		end,
		0
from 		C_CUC_CARGA 
where 	CC IN ( '210315','210320','210325','210330') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		32, 
		cc, 
		saldo_numerico, 
		case 
		when CC IN ( '2103') then saldo_numerico
		else 0
		end,
		0
from 		C_CUC_CARGA 
where 	CC IN ( '2103') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		33, 
		cc, 
		saldo_numerico, 
		case 
		when CC IN ('26') then saldo_numerico
		else 0 end,
		0	saldo_numerico 
from 		C_CUC_CARGA 
where 	CC IN ('26') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		35, 
		cc, 
		saldo_numerico, 
		case 
		when CC IN ( '27') then saldo_numerico
		else 0
		end,
		0
from 		C_CUC_CARGA 
where 	CC IN ( '27') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		36, 
		cc, 
		saldo_numerico, 
		case 
		when CC in ( '22','23','24','25','29','2102') then saldo_numerico
		else 0 end,
		0	saldo_numerico 
from 		C_CUC_CARGA 
where 	CC IN ( '22','23','24','25','29','2102') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		37, 
		cc, 
		saldo_numerico, 
		case 
		when CC in ( '28') then saldo_numerico
		else 0
		end,
		0
from 		C_CUC_CARGA 
where 	CC IN ( '28') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		38, 
		cc, 
		saldo_numerico, 
		case 
		when CC in ( '2') then saldo_numerico
		else 0
		end,
		0
from 		C_CUC_CARGA 
where 	CC IN ( '2') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		39, 
		cc, 
		saldo_numerico, 
		case 
		when CC IN ( '31') then saldo_numerico
		else 0
		end,
		0
from 		C_CUC_CARGA 
where 	CC IN ( '31') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		40, 
		cc, 
		saldo_numerico, 
		case 
		when CC IN ('3402','330115') then saldo_numerico
		else 0
		end,
		0
from 		C_CUC_CARGA 
where 	CC IN ('3402','330115') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		42, 
		cc, 
		saldo_numerico, 
		case 
		when CC IN ( '3601','3602') then saldo_numerico
		else 0
		end,
		0
from 		C_CUC_CARGA 
where 	CC IN ( '3601','3602') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		43, 
		cc, 
		saldo_numerico, 
		case 
		when CC in ('5') then saldo_numerico
		else 0 end,
		case 
		when CC in ('4') then saldo_numerico 
		else 0 end
from 		C_CUC_CARGA 
where 	CC IN ( '5','4') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		44, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('32','33','34','35','37') then saldo_numerico
		else 0
		end,
		case 
		when CC IN ('3402','330115') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('32','33','34','35','37','3402','330115') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		45, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ( '3','5') then saldo_numerico
		else 0
		end,
		case 
		when CC IN ( '3603','3604','4') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('3603','3604','4','3','5') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		46, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ( '3','5','2') then saldo_numerico
		else 0
		end,
		case 
		when CC IN ( '3603','3604','4') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('3603','3604','4','3','5','2') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		100, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1401','1402','1403','1404','1405','1406','1407','1408','1473','1474') then saldo_numerico
		else 0
		end,
		0
from 		C_CUC_CARGA 
where 	CC IN ('1401','1402','1403','1404','1405','1406','1407','1408','1473','1474') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		101, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('142505','142605','142705','142805','142905','143005','144905','145005', '145105','145205','145305','145405','143105','143205','145505','145605','147905','148005','148505','148605') then saldo_numerico
		else 0
		end,
		0
from 		C_CUC_CARGA 
where 	CC IN ('142505','142605','142705','142805','142905','143005','144905','145005', '145105','145205','145305','145405','143105','143205','145505','145605','147905','148005','148505','148605') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		102, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1425','1426','1427','1428','1429','1430','1449','1450','1451','1452','1453','1454','1431','1432','1455','1456','1479','1480','1485','1486') then saldo_numerico
		else 0
		end,
		case 
		when CC IN ('142505','142605','142705','142805','142905','143005','144905','145005','145105','145205','145305','145405','143105','143205','145505','145605','147905','148005','148505','148605') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('1425','1426','1427','1428','1429','1430','1449','1450','1451','1452','1453','1454','1431','1432','1455','1456','1479','1480','1485','1486','142505','142605','142705','142805','142905','143005','144905','145005','145105','145205','145305','145405','143105','143205','145505','145605','147905','148005','148505','148605') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		149, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1404') then saldo_numerico
		else 0
		end,
		0
from 		C_CUC_CARGA 
where 	CC IN ('1404') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		150, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('142805','145205') then saldo_numerico
		else 0
		end,
		0
from 		C_CUC_CARGA 
where 	CC IN ('142805','145205') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		151, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1428','1452') then saldo_numerico
		else 0
		end,
		case 
		when CC IN  ('142805','145205') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('1428','1452','142805','145205') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		256, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1417','1418','1419','1420','1421','1422','1423','1424','1477','1478') then saldo_numerico
		else 0
		end,
		0
from 		C_CUC_CARGA 
where 	CC IN ('1417','1418','1419','1420','1421','1422','1423','1424','1477','1478') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		331, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('144105','144205','144305','144405','144505','144605','144705','144805','146505','146605','146705','146805','146905','147005','147105','147205','148305','148405','148905','149005') then saldo_numerico
		else 0
		end,
		0
from 		C_CUC_CARGA 
where 	CC IN ('144105','144205','144305','144405','144505','144605','144705','144805','146505','146605','146705','146805','146905','147005','147105','147205','148305','148405','148905','149005') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		332, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1441','1442','1443','1444','1445','1446','1447','1448','1465','1466','1467','1468','1469','1470','1471','1472','1483','1484','1489','1490') then saldo_numerico
		else 0
		end,
		case 
		when CC IN  ('144105','144205','144305','144405','144505','144605','144705','144805','146505','146605','146705','146805','146905','147005','147105','147205','148305','148405','148905','149005') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('1441','1442','1443','1444','1445','1446','1447','1448','1465','1466','1467','1468','1469','1470','1471','1472','1483','1484','1489','1490','144105','144205','144305','144405','144505','144605','144705','144805','146505','146605','146705','146805','146905','147005','147105','147205','148305','148405','148905','149005') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		257, 
		cc, 
		saldo_numerico, 
		case 
		when CC in ('14') then saldo_numerico
		when CC in ('1499') then abs(saldo_numerico)
		else 0 end,
		0 saldo_numerico
from 		C_CUC_CARGA 
where 	CC IN ( '14','1499') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		258, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1420') then saldo_numerico
		else 0
		end,
		0
from 		C_CUC_CARGA 
where 	CC IN ('1420') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		335, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('144405','146805') then saldo_numerico
		else 0
		end,
		0
from 		C_CUC_CARGA 
where 	CC IN ('144405','146805') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		336, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1444','1468') then saldo_numerico
		else 0
		end,
		case 
		when CC IN  ('144405','146805') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('1444','1468','144405','146805') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		259, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1404','1412','1420','1428','1436','1444','1452','1460','1468') then saldo_numerico
		else 0
		end,
		0
from 		C_CUC_CARGA 
where 	CC IN ('1404','1412','1420','1428','1436','1444','1452','1460','1468') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		195, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('149920') then abs(saldo_numerico)
		else 0
		end,
		0
from 		C_CUC_CARGA 
where 	CC IN ('149920') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		301, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1409','1410','1411','1412','1413','1414','1415','1416','1475','1476') then saldo_numerico
		else 0
		end,
		0
from 		C_CUC_CARGA 
where 	CC IN ('1409','1410','1411','1412','1413','1414','1415','1416','1475','1476') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		333, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('143305','143405','143505','143605','143705','143805','143905','144005','145705','145805','145905','146005','146105','146205','146305','146405','148105','148205','148705','148805') then saldo_numerico
		else 0
		end,
		0
from 		C_CUC_CARGA 
where 	CC IN ('143305','143405','143505','143605','143705','143805','143905','144005','145705','145805','145905','146005','146105','146205','146305','146405','148105','148205','148705','148805') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		334, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1433','1434','1435','1436','1437','1438','1439','1440','1457','1458','1459','1460','1461','1462','1463','1464','1481','1482','1487','1488') then saldo_numerico
		else 0
		end,
		case 
		when CC IN  ('143305','143405','143505','143605','143705','143805','143905','144005','145705','145805','145905','146005','146105','146205','146305','146405','148105','148205','148705','148805') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('1433','1434','1435','1436','1437','1438','1439','1440','1457','1458','1459','1460','1461','1462','1463','1464','1481','1482','1487','1488','143305','143405','143505','143605','143705','143805','143905','144005','145705','145805','145905','146005','146105','146205','146305','146405','148105','148205','148705','148805') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		302, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1412') then saldo_numerico
		else 0
		end,
		0
from 		C_CUC_CARGA 
where 	CC IN ('1412') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		337, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('143605','146005') then saldo_numerico
		else 0
		end,
		0
from 		C_CUC_CARGA 
where 	CC IN ('143605','146005') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		338, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1436','1460') then saldo_numerico
		else 0
		end,
		case 
		when CC IN  ('143605','146005') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('1436','1460','143605','146005') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		347, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('12','15','170105','170110','170115','190205','190210','190215','190220','190240','190250','190280','190286','1903') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('12','15','170105','170110','170115','190205','190210','190215','190220','190240','190250','190280','190286','1903') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		348, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1103','12','15','170105','170110','170115','190205','190210','190215','190220','190240','190250','190280','190286','1903') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('1103','12','15','170105','170110','170115','190205','190210','190215','190220','190240','190250','190280','190286','1903') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		349, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1103','12','15','1701','190205','190210','190215','190220','190240','190250','190280','190286','1903') then saldo_numerico
		else 0
		end,
		case 
		when CC IN  ('170120') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('1103','12','15','1701','190205','190210','190215','190220','190240','190250','190280','190286','1903','170120') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		350, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('2102','22','27','280105','2903','2904') then saldo_numerico
		else 0
		end,
		case 
		when CC IN  ('210110','210130','210150','210210','210330','2203','2790') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('2102','22','27','280105','2903','2904','210110','210130','210150','210210','210330','2203','2790') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		351, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('142505','144905') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('142505','144905') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		352, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1425','1449') then saldo_numerico
		else 0
		end,
		case 
		when CC in  ('142505','144905') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('1425','1449','142505','144905') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		353, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('144105','146505') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('144105','146505') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		354, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1441','1465') then saldo_numerico
		else 0
		end,
		case 
		when CC in  ('144105','146505') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('1441','1465','144105','146505') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		355, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('143305','145705') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('143305','145705') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		356, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1433','1457') then saldo_numerico
		else 0
		end,
		case 
		when CC in  ('143305','145705') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('1433','1457','143305','145705') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		357, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1401','1409','1417','1425','1433','1441','1449','1457','1465') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('1401','1409','1417','1425','1433','1441','1449','1457','1465') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		358, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('142605','145005') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('142605','145005') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		359, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1426','1450') then saldo_numerico
		else 0
		end,
		case 
		when CC in  ('142605','145005') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('1426','1450','142605','145005') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		360, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('144205','146605') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('144205','146605') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		361, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1442','1466') then saldo_numerico
		else 0
		end,
		case 
		when CC in  ('144205','146605') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('1442','1466','144205','146605') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		362, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('143405','145805') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('143405','145805') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		363, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1434','1458') then saldo_numerico
		else 0
		end,
		case 
		when CC in  ('143405','145805') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('1434','1458','143405','145805') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		364, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1402','1410','1418','1426','1434','1442','1450','1458','1466') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('1402','1410','1418','1426','1434','1442','1450','1458','1466') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		365, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('142705','145105') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('142705','145105') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		366, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1427','1451') then saldo_numerico
		else 0
		end,
		case 
		when CC in  ('142705','145105') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('1427','1451','142705','145105') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		367, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('144305','146705') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('144305','146705') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		368, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1443','1467') then saldo_numerico
		else 0
		end,
		case 
		when CC in  ('144305','146705') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('1443','1467','144305','146705') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		369, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('143505','145905') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('143505','145905') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		370, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1435','1459') then saldo_numerico
		else 0
		end,
		case 
		when CC in  ('143505','145905') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('1435','1459','143505','145905') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		371, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1403','1411','1419','1427','1435','1443','1451','1459','1467') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('1403','1411','1419','1427','1435','1443','1451','1459','1467') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		372, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('142905','145305') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('142905','145305') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		373, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1429','1453') then saldo_numerico
		else 0
		end,
		case 
		when CC in  ('142905','145305') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('1429','1453','142905','145305') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		374, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('144505','146905') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('144505','146905') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		375, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1445','1469') then saldo_numerico
		else 0
		end,
		case 
		when CC in  ('144505','146905') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('1445','1469','144505','146905') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		376, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('143705','146105') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('143705','146105') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		377, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1437','1461') then saldo_numerico
		else 0
		end,
		case 
		when CC in  ('143705','146105') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('1437','1461','143705','146105') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		378, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1405','1413','1421','1429','1437','1445','1453','1461','1469') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('1405','1413','1421','1429','1437','1445','1453','1461','1469') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		379, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('143005','145405') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('143005','145405') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		380, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1430','1454') then saldo_numerico
		else 0
		end,
		case 
		when CC in  ('143005','145405') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('1430','1454','143005','145405') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		381, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('144605','147005') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('144605','147005') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		382, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1446','1470') then saldo_numerico
		else 0
		end,
		case 
		when CC in  ('144605','147005') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('1446','1470','144605','147005') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		383, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('143805','146205') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('143805','146205') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		384, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1438','1462') then saldo_numerico
		else 0
		end,
		case 
		when CC in  ('143805','146205') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('1438','1462','143805','146205') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		385, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1406','1414','1422','1430','1438','1446','1454','1462','1470') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('1406','1414','1422','1430','1438','1446','1454','1462','1470') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		386, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('143105','145505') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('143105','145505') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		387, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1431','1455') then saldo_numerico
		else 0
		end,
		case 
		when CC in  ('143105','145505') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('1431','1455','143105','145505') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		388, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('144705','147105') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('144705','147105') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		389, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1447','1471') then saldo_numerico
		else 0
		end,
		case 
		when CC in  ('144705','147105') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('1447','1471','144705','147105') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		390, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('143905','146305') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('143905','146305') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		391, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1439','1463') then saldo_numerico
		else 0
		end,
		case 
		when CC in  ('143905','146305') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('1439','1463','143905','146305') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		392, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1407','1415','1423','1431','1439','1447','1455','1463','1471') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('1407','1415','1423','1431','1439','1447','1455','1463','1471') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		393, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('143205','145605') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('143205','145605') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		394, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1432','1456') then saldo_numerico
		else 0
		end,
		case 
		when CC in  ('143205','145605') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('1432','1456','143205','145605') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		395, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('144805','147205') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('144805','147205') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		396, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1448','1472') then saldo_numerico
		else 0
		end,
		case 
		when CC in  ('144805','147205') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('1448','1472','144805','147205') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		397, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('144005','146405') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('144005','146405') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		398, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1440','1464') then saldo_numerico
		else 0
		end,
		case 
		when CC in  ('144005','146405') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('1440','1464','144005','146405') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		399, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1408','1416','1424','1432','1440','1448','1456','1464','1472') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('1408','1416','1424','1432','1440','1448','1456','1464','1472') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		400, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('147905','148505') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('147905','148505') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		401, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1479','1485') then saldo_numerico
		else 0
		end,
		case 
		when CC in  ('147905','148505') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('1479','1485','147905','148505') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		402, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('148305','148905') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('148305','148905') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		403, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1483','1489') then saldo_numerico
		else 0
		end,
		case 
		when CC in  ('148305','148905') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('1483','1489','148305','148905') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		404, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('148105','148705') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('148105','148705') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		405, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1481','1487') then saldo_numerico
		else 0
		end,
		case 
		when CC in  ('148105','148705') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('1481','1487','148105','148705') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		406, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1473','1475','1477','1479','1481','1483','1485','1487','1489') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('1473','1475','1477','1479','1481','1483','1485','1487','1489') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		407, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('148005','148605') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('148005','148605') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		408, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1480','1486') then saldo_numerico
		else 0
		end,
		case 
		when CC in  ('148005','148605') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('1480','1486','148005','148605') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		409, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('148405','149005') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('148405','149005') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		410, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1484','1490') then saldo_numerico
		else 0
		end,
		case 
		when CC in  ('148405','149005') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('1484','1490','148405','149005') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		411, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('148205','148805') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('148205','148805') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		412, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1482','1488') then saldo_numerico
		else 0
		end,
		case 
		when CC in  ('148205','148805') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('1482','1488','148205','148805') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		413, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1474','1476','1478','1480','1482','1484','1486','1488','1490') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('1474','1476','1478','1480','1482','1484','1486','1488','1490') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		414, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('149905','741401','741409','741420') then abs(saldo_numerico)
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('149905','741401','741409','741420') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		415, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('149910','741402','741410','741417','741421') then abs(saldo_numerico)
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('149910','741402','741410','741417','741421') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		416, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('149915','741403','741411','741422') then abs(saldo_numerico)
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('149915','741403','741411','741422') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		417, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('741404','741412','741418','741423') then abs(saldo_numerico)
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('741404','741412','741418','741423') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		418, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('149925','741405','741413','741424') then abs(saldo_numerico)
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('149925','741405','741413','741424') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		419, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('149930','741406','741414','741425') then abs(saldo_numerico)
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('149930','741406','741414','741425') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		420, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('149935','741430','741434','741438','741439') then abs(saldo_numerico)
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('149935','741430','741434','741438','741439') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		421, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('149940','741431','741435','741440') then abs(saldo_numerico)
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('149940','741431','741435','741440') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		422, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('149955','741419','741432','741436','741441') then abs(saldo_numerico)
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('149955','741419','741432','741436','741441') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		423, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('149960','741433','741437','741442') then abs(saldo_numerico)
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('149960','741433','741437','741442') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		424, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('4810','4890') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('4810','4890') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		425, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('46','4703') then saldo_numerico
		else 0
		end,
		case 
		when CC in  ('5501') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('46','4703','5501') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		426, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('4810') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('4810') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		427, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('2104') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('2104') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		428, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('510405') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('510405') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		429, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1401') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('1401') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		430, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('510410') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('510410') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		431, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1402') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('1402') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		432, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('510415') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('510415') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		433, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1403') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('1403') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		434, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('510420') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('510420') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		435, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1404') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('1404') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		436, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('510421') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('510421') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		437, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1405') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('1405') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		438, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('510425') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('510425') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		439, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1406') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('1406') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		440, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('510426') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('510426') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		441, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1407') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('1407') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		442, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('510427') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('510427') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		443, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1408') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('1408') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		444, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('510428') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('510428') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		445, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1473') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('1473') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		446, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('510429') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('510429') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		447, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1474') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('1474') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		448, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('510430') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('510430') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		449, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('510435') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('510435') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		450, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('2102') then saldo_numerico
		else 0
		end,
		case 
		when CC in  ('2104') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('2102','2104') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		451, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1201','1202') then saldo_numerico
		else 0
		end,
		case 
		when CC in  ('1105','2201','2202','2102','130505','130550','130605','130510','130555','130610') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('1201','1202','1105','2201','2202','2102','130505','130550','130605','130510','130555','130610') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		452, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1201','1202') then saldo_numerico
		else 0
		end,
		case 
		when CC in  ('1105','2201','2202','2102','130615','130605','130610') then saldo_numerico
		else 0
		end
from 		C_CUC_CARGA 
where 	CC IN ('1201','1202','1105','2201','2202','2102','130615','130605','130610') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		453, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('560405','560410','560420') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('560405','560410','560420') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		457, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1425','1426','1427','1428','1429','1430','1431','1432','1479','1480') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('1425','1426','1427','1428','1429','1430','1431','1432','1479','1480') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		458, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1449','1450','1451','1452','1453','1454','1455','1456','1485','1486') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('1449','1450','1451','1452','1453','1454','1455','1456','1485','1486') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		459, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1441','1442','1443','1444','1445','1446','1447','1448','1483','1484') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('1441','1442','1443','1444','1445','1446','1447','1448','1483','1484') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		460, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1465','1466','1467','1468','1469','1470','1471','1472','1489','1490') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('1465','1466','1467','1468','1469','1470','1471','1472','1489','1490') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		461, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1433','1434','1435','1436','1437','1438','1439','1440','1481','1482') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('1433','1434','1435','1436','1437','1438','1439','1440','1481','1482') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		462, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1457','1458','1459','1460','1461','1462','1463','1464','1487','1488') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('1457','1458','1459','1460','1461','1462','1463','1464','1487','1488') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		463, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1428') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('1428') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		464, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1452') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('1452') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		465, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1444') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('1444') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		466, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1468') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('1468') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		467, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1436') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('1436') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS01
select 	ORGANIZACION_ID,  
		PERIODO_ID, 
		468, 
		cc, 
		saldo_numerico, 
		case 
		when CC in  ('1460') then saldo_numerico
		else 0
		end,
    0
from 		C_CUC_CARGA 
where 	CC IN ('1460') AND ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO;

INSERT INTO AUX_CARGA_CUC_PASS02
select ORGANIZACION_ID, 
	PERIODO_ID, 
	RUBRO_ID, 
	SUM(SALDO_NUMERICO_SUMA) SALDO_NUMERICO_SUMA, 
	SUM(SALDO_NUMERICO_RESTA) SALDO_NUMERICO_RESTA, 
	SUM(SALDO_NUMERICO_SUMA) - SUM(SALDO_NUMERICO_RESTA) SALDO_NUMERICO
from 	dbo.AUX_CARGA_CUC_PASS01
where ORGANIZACION_ID = @ORGANIZACION AND PERIODO_ID = @PERIODO
GROUP BY ORGANIZACION_ID, PERIODO_ID, RUBRO_ID;
