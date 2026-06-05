Add-Type -AssemblyName System.Drawing

$width = 1600
$height = 2600

function S([int[]] $codes) {
    return -join ($codes | ForEach-Object { [char]$_ })
}

$bitmap = New-Object System.Drawing.Bitmap($width, $height)
$graphics = [System.Drawing.Graphics]::FromImage($bitmap)
$graphics.SmoothingMode = [System.Drawing.Drawing2D.SmoothingMode]::AntiAlias
$graphics.TextRenderingHint = [System.Drawing.Text.TextRenderingHint]::AntiAliasGridFit
$graphics.Clear([System.Drawing.Color]::FromArgb(246, 250, 255))

$borderPen = New-Object System.Drawing.Pen([System.Drawing.Color]::FromArgb(23, 50, 77), 4)
$arrowPen = New-Object System.Drawing.Pen([System.Drawing.Color]::FromArgb(23, 50, 77), 4)
$arrowPen.CustomEndCap = New-Object System.Drawing.Drawing2D.AdjustableArrowCap(8, 10)

$terminalBrush = New-Object System.Drawing.SolidBrush([System.Drawing.Color]::FromArgb(225, 240, 255))
$processBrush = New-Object System.Drawing.SolidBrush([System.Drawing.Color]::White)
$decisionBrush = New-Object System.Drawing.SolidBrush([System.Drawing.Color]::FromArgb(255, 244, 232))
$ioBrush = New-Object System.Drawing.SolidBrush([System.Drawing.Color]::FromArgb(235, 255, 242))
$noteBrush = New-Object System.Drawing.SolidBrush([System.Drawing.Color]::FromArgb(244, 240, 255))
$textBrush = [System.Drawing.Brushes]::DarkSlateGray

$fontTitle = New-Object System.Drawing.Font('Segoe UI', 24, [System.Drawing.FontStyle]::Bold)
$fontSub = New-Object System.Drawing.Font('Segoe UI', 20, [System.Drawing.FontStyle]::Bold)
$fontText = New-Object System.Drawing.Font('Segoe UI', 16)
$fontSmall = New-Object System.Drawing.Font('Segoe UI', 14, [System.Drawing.FontStyle]::Bold)

function Draw-CenteredText {
    param(
        [string] $Text,
        [System.Drawing.Font] $Font,
        [float] $X,
        [float] $Y,
        [float] $W,
        [float] $H
    )

    $format = New-Object System.Drawing.StringFormat
    $format.Alignment = [System.Drawing.StringAlignment]::Center
    $format.LineAlignment = [System.Drawing.StringAlignment]::Center
    $rect = New-Object System.Drawing.RectangleF($X, $Y, $W, $H)
    $graphics.DrawString($Text, $Font, $textBrush, $rect, $format)
}

function Draw-RectBlock {
    param(
        [System.Drawing.Brush] $Brush,
        [int] $X,
        [int] $Y,
        [int] $W,
        [int] $H
    )
    $graphics.FillRectangle($Brush, $X, $Y, $W, $H)
    $graphics.DrawRectangle($borderPen, $X, $Y, $W, $H)
}

function Draw-DiamondBlock {
    param(
        [System.Drawing.Brush] $Brush,
        [int] $Cx,
        [int] $Cy,
        [int] $HalfW,
        [int] $HalfH
    )

    [System.Drawing.Point[]] $points = @(
        (New-Object System.Drawing.Point($Cx, ($Cy - $HalfH))),
        (New-Object System.Drawing.Point(($Cx + $HalfW), $Cy)),
        (New-Object System.Drawing.Point($Cx, ($Cy + $HalfH))),
        (New-Object System.Drawing.Point(($Cx - $HalfW), $Cy))
    )

    $graphics.FillPolygon($Brush, $points)
    $graphics.DrawPolygon($borderPen, $points)
}

function Draw-Arrow {
    param([int] $X1, [int] $Y1, [int] $X2, [int] $Y2)
    $graphics.DrawLine($arrowPen, $X1, $Y1, $X2, $Y2)
}

$textStart = S @(1053,1072,1095,1072,1083,1086)
$textInput = (S @(1042,1074,1086,1076,32,1091,1088,1072,1074,1085,1077,1085,1080,1103)) + "`n27 - x = 17"
$textNormalize = (S @(1055,1086,1076,1075,1086,1090,1086,1074,1082,1072,32,1089,1090,1088,1086,1082,1080)) + "`n" + (S @(1059,1076,1072,1083,1080,1090,1100,32,1087,1088,1086,1073,1077,1083,1099,32,1080,32,1088,1072,1079,1076,1077,1083,1080,1090,1100,32,1087,1086,32,1079,1085,1072,1082,1091,32,61))
$textEqCheck = (S @(1047,1085,1072,1082,32,61,32,1085,1072,1081,1076,1077,1085)) + "`n" + (S @(1088,1086,1074,1085,1086,32,1086,1076,1080,1085,32,1088,1072,1079,63))
$textNo = S @(1053,1077,1090)
$textEqError = (S @(1054,1096,1080,1073,1082,1072,32,1092,1086,1088,1084,1072,1090,1072)) + "`n" + (S @(1091,1088,1072,1074,1085,1077,1085,1080,1103))
$textYes = S @(1044,1072)
$textOperator = (S @(1054,1087,1088,1077,1076,1077,1083,1077,1085,1080,1077,32,1086,1087,1077,1088,1072,1090,1086,1088,1072)) + "`n" + (S @(1055,1088,1086,1074,1077,1088,1080,1090,1100,32,1085,1072,1083,1080,1095,1080,1077,32,1086,1076,1085,1086,1075,1086,32,1080,1079,32,1089,1080,1084,1074,1086,1083,1086,1074,58,32,43,44,32,45,44,32,42,44,32,47))
$textOperatorCheck = S @(1054,1087,1077,1088,1072,1090,1086,1088,32,1085,1072,1081,1076,1077,1085,63)
$textOperatorError = (S @(1054,1096,1080,1073,1082,1072,58)) + "`n" + (S @(1086,1087,1077,1088,1072,1090,1086,1088,32,1085,1077,32,1085,1072,1081,1076,1077,1085))
$textPosition = (S @(1054,1087,1088,1077,1076,1077,1083,1077,1085,1080,1077,32,1087,1086,1083,1086,1078,1077,1085,1080,1103,32,1085,1077,1080,1079,1074,1077,1089,1090,1085,1086,1081)) + "`n" + (S @(1056,1072,1079,1076,1077,1083,1080,1090,1100,32,1083,1077,1074,1091,1102,32,1095,1072,1089,1090,1100,32,1085,1072,32,1076,1074,1072,32,1086,1087,1077,1088,1072,1085,1076,1072,32,1080,32,1086,1087,1088,1077,1076,1077,1083,1080,1090,1100,44,32,1075,1076,1077,32,1085,1072,1093,1086,1076,1080,1090,1089,1103,32,120))
$textCalc = (S @(1042,1099,1095,1080,1089,1083,1077,1085,1080,1077,32,120)) + "`n+ : x = result - known`n- : x = result + known " + (S @(1080,1083,1080)) + " known - result`n* : x = result / known`n/ : x = result * known " + (S @(1080,1083,1080)) + " known / result"
$textOutput = (S @(1042,1099,1074,1086,1076,32,1088,1077,1079,1091,1083,1100,1090,1072,1090,1072)) + "`n" + (S @(1055,1086,1082,1072,1079,1072,1090,1100,32,1086,1087,1077,1088,1072,1090,1086,1088,44,32,1087,1086,1083,1086,1078,1077,1085,1080,1077,32,120,32,1080,32,1085,1072,1081,1076,1077,1085,1085,1086,1077,32,1079,1085,1072,1095,1077,1085,1080,1077))
$textFinish = S @(1050,1086,1085,1077,1094)

$graphics.FillEllipse($terminalBrush, 610, 40, 380, 110)
$graphics.DrawEllipse($borderPen, 610, 40, 380, 110)
Draw-CenteredText $textStart $fontTitle 610 40 380 110

Draw-Arrow 800 150 800 235
Draw-RectBlock $ioBrush 480 235 640 120
Draw-CenteredText $textInput $fontSub 480 235 640 120

Draw-Arrow 800 355 800 455
Draw-RectBlock $processBrush 390 455 820 145
Draw-CenteredText $textNormalize $fontSub 390 455 820 145

Draw-Arrow 800 600 800 710
Draw-DiamondBlock $decisionBrush 800 835 235 125
Draw-CenteredText $textEqCheck $fontSub 620 770 360 130
Draw-Arrow 1035 835 1320 835
$graphics.DrawString($textNo, $fontSmall, $textBrush, 1085, 805)
Draw-RectBlock $noteBrush 1320 760 220 140
Draw-CenteredText $textEqError $fontText 1320 760 220 140
$graphics.DrawString($textYes, $fontSmall, $textBrush, 830, 980)
Draw-Arrow 800 960 800 1045

Draw-RectBlock $processBrush 330 1045 940 160
Draw-CenteredText $textOperator $fontSub 330 1045 940 160

Draw-Arrow 800 1205 800 1310
Draw-DiamondBlock $decisionBrush 800 1435 235 125
Draw-CenteredText $textOperatorCheck $fontSub 620 1380 360 110
Draw-Arrow 1035 1435 1320 1435
$graphics.DrawString($textNo, $fontSmall, $textBrush, 1085, 1405)
Draw-RectBlock $noteBrush 1320 1360 220 140
Draw-CenteredText $textOperatorError $fontText 1320 1360 220 140
$graphics.DrawString($textYes, $fontSmall, $textBrush, 830, 1580)
Draw-Arrow 800 1560 800 1645

Draw-RectBlock $processBrush 260 1645 1080 185
Draw-CenteredText $textPosition $fontSub 260 1645 1080 185

Draw-Arrow 800 1830 800 1925
Draw-RectBlock $processBrush 210 1925 1180 235
Draw-CenteredText $textCalc $fontText 210 1925 1180 235

Draw-Arrow 800 2160 800 2250
Draw-RectBlock $ioBrush 360 2250 880 140
Draw-CenteredText $textOutput $fontSub 360 2250 880 140

Draw-Arrow 800 2390 800 2470
$graphics.FillEllipse($terminalBrush, 610, 2470, 380, 110)
$graphics.DrawEllipse($borderPen, 610, 2470, 380, 110)
Draw-CenteredText $textFinish $fontTitle 610 2470 380 110

$bitmap.Save((Join-Path $PSScriptRoot 'flowchart.png'), [System.Drawing.Imaging.ImageFormat]::Png)

$fontTitle.Dispose()
$fontSub.Dispose()
$fontText.Dispose()
$fontSmall.Dispose()
$terminalBrush.Dispose()
$processBrush.Dispose()
$decisionBrush.Dispose()
$ioBrush.Dispose()
$noteBrush.Dispose()
$borderPen.Dispose()
$arrowPen.Dispose()
$graphics.Dispose()
$bitmap.Dispose()
