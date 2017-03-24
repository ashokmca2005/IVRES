<div style="width:975px;">
    <div class="box-t">
        <div class="box-r">
            <div class="box-b">
                <div class="box-l">
                    <div class="box-tr">
                        <div class="box-br">
                            <div class="box-bl">
                                <div class="box-tl">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                                        <tr>
                                            <td align="left" valign="top">
												<?php
                                                $itms 	= $_GET['itm'];
                                                if(substr($itms, strlen($itms)-1,strlen($itms)) == "-")
                                                    $itms 	= substr($itms, 0, strlen($itms)-1);
                                                $property_arr = explode('-', $itms);
                                                $propertyObj->fun_createCompareProperties($property_arr);
                                                ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
