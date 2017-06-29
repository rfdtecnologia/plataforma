<?php
/**
 * Created by PhpStorm.
 * User: dparedes
 * Date: 06/06/2017
 * Time: 18:59
 */
include ('../librerias/libs_sql.php');
$organizacion = base64_decode($_GET['o']);
$fecha_i = $_GET['fi'];
$fecha_f = $_GET['ff'];
Conectar();

$consulta = "select
      a16.NOMBRE_ORGANIZACION  NOMBRE_ORGANIZACION,
      DATEPART(YEAR, a11.FECHA)  ANIO,
      DATEPART(MONTH, a11.FECHA)  MES,
      max(a13.NOMBRE_ENCUESTA)  NOMBRE_ENCUESTA,
      max(a12.NOMBRE_AGENCIA)  NOMBRE_AGENCIA,
      max(a15.NOMBRE_USUARIO)  NOMBRE_USUARIO,
      count(distinct a11.CODIGO_ENCUESTA)  NUMERO_ENCUESTAS
from  V_RESULTADO_ECUESTA     a11
      join  C_AGENCIAS  a12
        on (a11.AGENCIA_ID = a12.AGENCIA_ID and 
      a11.ORGANIZACION_ID = a12.ORGANIZACION_ID)
      join  C_ENCUESTA  a13
        on (a11.ENCUESTA_ID = a13.ENCUESTA_ID)
      join  C_MES a14
        on (DATEPART(MONTH, a11.FECHA) = a14.MES_ID)
      join  C_USUARIO_GENERAL a15
        on (a11.ORGANIZACION_ID = a15.ORGANIZACION_ID and 
      a11.USUARIO_ID = a15.USUARIO_ID)
      join  C_ORGANIZACION    a16
        on (a11.ORGANIZACION_ID = a16.ORGANIZACION_ID)
where 
  a11.ENCUESTA_ID <> 6 and 
  a11.ORGANIZACION_ID = $organizacion and a11.FECHA between '$fecha_i' and '$fecha_f'   
group by
a16.NOMBRE_ORGANIZACION,
DATEPART(YEAR, a11.FECHA),
DATEPART(MONTH, a11.FECHA),
a11.ENCUESTA_ID,
a11.AGENCIA_ID,
a11.USUARIO_ID";
$resultado = ConsultarTabla($consulta);
$filas = NumeroColumnas($resultado);
if($filas > 0 ){

    date_default_timezone_set('America/Mexico_City');

    if (PHP_SAPI == 'cli')
        die('Este archivo solo se puede ver desde un navegador web');

    /** Se agrega la libreria PHPExcel */
    require_once '../inc/lib/PHPExcel/PHPExcel.php';

    // Se crea el objeto PHPExcel
    $objPHPExcel = new PHPExcel();

    // Se asignan las propiedades del libro
    $objPHPExcel->getProperties()->setCreator("Codedrinks") //Autor
    ->setLastModifiedBy("Codedrinks") //Ultimo usuario que lo modificó
    ->setTitle("Reporte Excel con PHP y MySQL")
        ->setSubject("Reporte Excel con PHP y MySQL")
        ->setDescription("Reporte de alumnos")
        ->setKeywords("reporte alumnos carreras")
        ->setCategory("Reporte excel");

    $tituloReporte = "Resumen Encuestas";
    $titulosColumnas = array(utf8_encode('ORGANIZACIÓN'), utf8_encode('AÑO'), 'MES', 'ENCUESTA', 'AGENCIA', 'USUARIO', utf8_encode('NÚMERO ENCUESTAS'));

    $objPHPExcel->setActiveSheetIndex(0)
        ->mergeCells('A1:G1');

    // Se agregan los titulos del reporte
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1',$tituloReporte)
        ->setCellValue('A2',  $titulosColumnas[0])
        ->setCellValue('B2',  $titulosColumnas[1])
        ->setCellValue('C2',  $titulosColumnas[2])
        ->setCellValue('D2',  $titulosColumnas[3])
        ->setCellValue('E2',  $titulosColumnas[4])
        ->setCellValue('F2',  $titulosColumnas[5])
        ->setCellValue('G2',  $titulosColumnas[6]);

    //Se agregan los datos de la encuesta
    $i = 3;
    $p = 0;
    while ($fila = mssql_fetch_row($resultado)) {
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' .$i,  utf8_encode(mssql_result($resultado, $p, "NOMBRE_ORGANIZACION")))
            ->setCellValue('B' . $i, mssql_result($resultado, $p, "ANIO"))
            ->setCellValue('C' . $i, mssql_result($resultado, $p, "MES"))
            ->setCellValue('D' . $i, utf8_encode(mssql_result($resultado, $p, "NOMBRE_ENCUESTA")))
            ->setCellValue('E' . $i, utf8_encode(mssql_result($resultado, $p, "NOMBRE_AGENCIA")))
            ->setCellValue('F' . $i, utf8_encode(mssql_result($resultado, $p, "NOMBRE_USUARIO")))
            ->setCellValue('G' . $i, utf8_encode(mssql_result($resultado, $p, "NUMERO_ENCUESTAS")));
        $i++;
        $p++;
    }
    $estiloTituloReporte = array(
        'font' => array(
            'name'      => 'Verdana',
            'bold'      => true,
            'italic'    => false,
            'strike'    => false,
            'size' =>16,
            'color'     => array(
                'rgb' => '222222'
            )
        ),
        'fill' => array(
            'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
            'color'	=> array('argb' => 'eeeeee')
        ),
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_NONE
            )
        ),
        'alignment' =>  array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'rotation'   => 0,
            'wrap'          => TRUE
        )
    );

    $estiloTituloColumnas = array(
        'font' => array(
            'name'      => 'Arial',
            'bold'      => true,
            'color'     => array(
                'rgb' => 'FFFFFF'
            )
        ),
        'fill' 	=> array(
            'type'		=> PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
            'rotation'   => 90,
            'startcolor' => array(
                'rgb' => '06069b'
            ),
            'endcolor'   => array(
                'argb' => 'FF431a5d'
            )
        ),
        /*'borders' => array(
            'top'     => array(
                'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                'color' => array(
                    'rgb' => '143860'
                )
            ),
            'bottom'     => array(
                'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                'color' => array(
                    'rgb' => '143860'
                )
            )
        ),*/
        'alignment' =>  array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap'          => TRUE
        ));

    $estiloInformacion = new PHPExcel_Style();
    $estiloInformacion->applyFromArray(
        array(
            'font' => array(
                'name'      => 'Arial',
                'color'     => array(
                    'rgb' => '222222'
                )
            ),
            'fill' 	=> array(
                'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
                'color'		=> array('argb' => 'eeeeee')
            ),
            'borders' => array(
                'left'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN ,
                    'color' => array(
                        'rgb' => '3a2a47'
                    )
                )
            )
        ));

    $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($estiloTituloReporte);
    $objPHPExcel->getActiveSheet()->getStyle('A2:G2')->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A3:G".($i-1));

    for($i = 'A'; $i <= 'G'; $i++){
        $objPHPExcel->setActiveSheetIndex(0)
            ->getColumnDimension($i)->setAutoSize(TRUE);
    }

    // Se asigna el nombre a la hoja
    $objPHPExcel->getActiveSheet()->setTitle('Resumen');

    // Se activa la hoja para que sea la que se muestre cuando el archivo se abre
    $objPHPExcel->setActiveSheetIndex(0);
    // Inmovilizar paneles
    //$objPHPExcel->getActiveSheet(0)->freezePane('A4');
    $objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,3);

    // Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Reportedealumnos.xlsx"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;

} else{
    print_r('No hay resultados para mostrar');
}
?>