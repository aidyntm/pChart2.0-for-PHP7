<?php   

/* pChart library inclusions */
chdir("../../");
require_once("bootstrap.php");

use pChart\pColor;
use pChart\pDraw;
use pChart\pCharts;
use pChart\pImageMap;

/* Create the pChart object */
/* 							X, Y, TransparentBackground, ImageMapIndex, ImageMapStorageMode, UniqueID, StorageFolder*/
$myPicture = new pImageMap(700,230,FALSE,"ImageMapAreaChart",IMAGE_MAP_STORAGE_FILE,"AreaChart","temp");

/* Retrieve the image map */
if (isset($_GET["ImageMap"]) || isset($_POST["ImageMap"])){
	$myPicture->dumpImageMap();
}

/* Populate the pData object */
$myPicture->myData->addPoints([4,2,10,12,8,3],"Probe 1");
$myPicture->myData->addPoints([3,12,15,8,5,5],"Probe 2");
$myPicture->myData->addPoints([2,7,5,18,15,22],"Probe 3");
$myPicture->myData->setSerieTicks("Probe 2",4);
$myPicture->myData->setAxisName(0,"Temperatures");
$myPicture->myData->addPoints(["Jan","Feb","Mar","Apr","May","Jun"],"Labels");
$myPicture->myData->setSerieDescription("Labels","Months");
$myPicture->myData->setAbscissa("Labels");

/* Turn off Anti-aliasing */
$myPicture->Antialias = FALSE;

/* Draw the background */ 
$myPicture->drawFilledRectangle(0,0,700,230,["Color"=>new pColor(170,183,87), "Dash"=>TRUE, "DashColor"=>new pColor(190,203,107)]); 

/* Overlay with a gradient */ 
$myPicture->drawGradientArea(0,0,700,230,DIRECTION_VERTICAL,["StartColor"=>new pColor(219,231,139,50), "EndColor"=>new pColor(1,138,68,50)]); 

/* Add a border to the picture */
$myPicture->drawRectangle(0,0,699,229,["Color"=>new pColor(0,0,0)]);

/* Write the chart title */ 
$myPicture->setFontProperties(array("FontName"=>"pChart/fonts/Forgotte.ttf","FontSize"=>11));
$myPicture->drawText(150,35,"Average temperature",array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));

/* Set the default font */
$myPicture->setFontProperties(array("FontName"=>"pChart/fonts/pf_arma_five.ttf","FontSize"=>6));

/* Define the chart area */
$myPicture->setGraphArea(60,40,650,200);

/* Draw the scale */
$scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"GridColor"=>new pColor(255,255,255),"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
$myPicture->drawScale($scaleSettings);

/* Write the chart legend */
$myPicture->drawLegend(540,20,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));

/* Turn on Anti-aliasing */
$myPicture->Antialias = TRUE;

$myCharts = new pCharts($myPicture);

/* Draw the area chart */
$myPicture->setShadow(TRUE,["X"=>1,"Y"=>1,"Color"=>new pColor(0,0,0,10)]);
$myCharts->drawAreaChart();

/* Draw a line and a plot chart on top */
$myCharts->drawLineChart();
$myCharts->drawPlotChart(["RecordImageMap"=>TRUE,"PlotBorder"=>TRUE,"PlotSize"=>3,"BorderSize"=>1,"Surrounding"=>-60,"BorderAlpha"=>80]);

/* Render the picture (choose the best way) */
$myPicture->autoOutput("temp/example.drawAreaChart.simple.png");

?>