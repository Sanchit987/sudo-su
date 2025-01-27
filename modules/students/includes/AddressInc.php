<?php

#**************************************************************************
#  openSIS is a free student information system for public and non-public 
#  colleges from Open Solutions for Education, Inc. web: www.os4ed.com
#
#  openSIS is  web-based, open source, and comes packed with features that 
#  include student demographic info, scheduling, grade book, attendance, 
#  report cards, eligibility, transcripts, parent portal, 
#  student portal and more.   
#
#  Visit the openSIS web site at http://www.opensis.com to learn more.
#  If you have question regarding this system or the license, please send 
#  an email to info@os4ed.com.
#
#  This program is released under the terms of the GNU General Public License as  
#  published by the Free Software Foundation, version 2 of the License. 
#  See license.txt.
#
#  This program is distributed in the hope that it will be useful,
#  but WITHOUT ANY WARRANTY; without even the implied warranty of
#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#  GNU General Public License for more details.
#
#  You should have received a copy of the GNU General Public License
#  along with this program.  If not, see <http://www.gnu.org/licenses/>.
#
#***************************************************************************************


include('../../../RedirectIncludes.php');
include 'modules/students/ConfigInc.php';

echo '<div id="modal_default_lookup" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">';
echo ' <input type=hidden id=p_type >';
echo ' <input type=hidden id=other_p_erson_id >';
if (clean_param($_REQUEST['func'], PARAM_NOTAGS) == 'search') {
    if ($_REQUEST['button'] == 'Find' || $_REQUEST['nfunc'] == 'status') {
        if ($_REQUEST['add_id'] == 'new')
            echo '<FORM name=sel_staff id=sel_staff action="ForWindow.php?modname=' . $_REQUEST[modname] . '&modfunc=lookup&type=' . $_REQUEST['type'] . '&func=search&nfunc=status&ajax=' . $_REQUEST['ajax'] . '&add_id=new&address_id=' . $_REQUEST['address_id'] . '" METHOD=POST>';
        else
            echo '<FORM name=sel_staff id=sel_staff action="ForWindow.php?modname=' . $_REQUEST[modname] . '&modfunc=lookup&type=' . $_REQUEST['type'] . '&func=search&nfunc=status&ajax=' . $_REQUEST['ajax'] . '&add_id=' . $_REQUEST['add_id'] . '&address_id=' . $_REQUEST['address_id'] . '" METHOD=POST>';
    }
}else {
    if ($_REQUEST['add_id'] == 'new')
        echo "<FORM class=\"form-horizontal\" name=popform id=popform action=ForWindow.php?modname=$_REQUEST[modname]&modfunc=lookup&type=" . $_REQUEST['type'] . "&func=search&ajax=" . $_REQUEST['ajax'] . "&add_id=new&address_id=" . $_REQUEST['address_id'] . " METHOD=POST>";
    else
        echo "<FORM class=\"form-horizontal\" name=popform id=popform action=ForWindow.php?modname=$_REQUEST[modname]&modfunc=lookup&type=" . $_REQUEST['type'] . "&func=search&ajax=" . $_REQUEST['ajax'] . "&add_id=" . $_REQUEST['add_id'] . "&address_id=" . $_REQUEST['address_id'] . " METHOD=POST>";
}


echo '<div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h5 class="modal-title">Lookup</h5>
                        </div>';

echo '<div class="modal-body">';
echo'<div id="modal-res">';



$x = 'ForWindow.php?modname=' . $_REQUEST['modname'] . '&modfunc=lookup&type=primary&ajax=' . $_REQUEST['ajax'] . '&address_id=' . $_REQUEST['address_id'] . '\'';
//            echo '<script>cleanModal(\'parent_res\');</script>';
echo '<div id=parent_res>';
echo '<h4 class="text-center">Search for an existing portal user (parent/guardian) <br/> to associate with this student.</h4>';
echo '<p class="text-danger text-center">Fill out one or more fields to look up an individual.</p>';

//echo '<div class=>';
echo '<div class="form-group"><label class="control-label col-xs-4">First Name</label><div class="col-xs-8">' . TextInput('', 'USERINFO_FIRST_NAME', '', 'class=form-control', true) . '</div></div>';
echo '<div class="form-group"><label class="control-label col-xs-4">Last Name</label><div class="col-xs-8">' . TextInput('', 'USERINFO_LAST_NAME', '', 'class=form-control', true) . '</div></div>';
echo '<div class="form-group"><label class="control-label col-xs-4">Email</label><div class="col-xs-8">' . TextInput('', 'USERINFO_EMAIL', '', 'class=form-control', true) . '</div></div>';
echo '<div class="form-group"><label class="control-label col-xs-4">Mobile Phone</label><div class="col-xs-8">' . TextInput('', 'USERINFO_MOBILE', '', 'class=form-control', true) . '</div></div>';
echo '<div class="form-group"><label class="control-label col-xs-4">Street Address</label><div class="col-xs-8">' . TextInput('', 'USERINFO_SADD', '', 'class=form-control', true) . '</div></div>';
echo '<div class="form-group"><label class="control-label col-xs-4">City</label><div class="col-xs-8">' . TextInput('', 'USERINFO_CITY', '', 'class=form-control', true) . '</div></div>';
echo '<div class="form-group"><label class="control-label col-xs-4">State</label><div class="col-xs-8">' . TextInput('', 'USERINFO_STATE', '', 'class=form-control', true) . '</div></div>';
echo '<div class="form-group"><label class="control-label col-xs-4">Zip</label><div class="col-xs-8">' . TextInput('', 'USERINFO_ZIP', '', 'class=form-control', true) . '</div></div>';
echo '<div class="modal-footer" id="parent-modal-footer"><INPUT  class="btn btn-primary" javascript:void(0); name=button value=Find onclick="parentLookup(\'' . $_REQUEST['address_id'] . '\')">&nbsp; &nbsp;<INPUT type=submit class="btn btn-default" name=button value=Cancel></div>';
echo '</div>';
echo '</div>';
echo '</div>';

//        }
;
//.modal-body



echo '</form>';
echo '</div>
                </div>
        </div>';
if (clean_param($_REQUEST['values'], PARAM_NOTAGS) && ($_POST['values'] || $_REQUEST['ajax'])) {

    if ($_REQUEST['r7'] == 'Y') {
        $get_home_add = DBGet(DBQuery('SELECT street_address_1,street_address_2,city,state,zipcode,bus_pickup,bus_dropoff,bus_no FROM student_address WHERE COLLEGE_ROLL_NO=\'' . UserStudentID() . '\' AND SYEAR=\'' . UserSyear() . '\' AND COLLEGE_ID= \'' . UserCollege() . '\' AND TYPE=\'Home Address\' '));
        if (count($get_home_add) > 0) {
            foreach ($get_home_add[1] as $gh_i => $gh_d) {
                if ($gh_d != '')
                    $_REQUEST['values']['student_address']['OTHER'][$gh_i] = $gh_d;
            }
        }
        else {
            echo "<script>show_home_error();</script>";
            unset($_REQUEST['values']);
        }
    }

    if ($_REQUEST['r4'] == 'Y') {
        $_REQUEST['values']['student_address']['MAIL']['STREET_ADDRESS_1'] = $_REQUEST['values']['student_address']['HOME']['STREET_ADDRESS_1'];
        $_REQUEST['values']['student_address']['MAIL']['STREET_ADDRESS_2'] = $_REQUEST['values']['student_address']['HOME']['STREET_ADDRESS_2'];
        $_REQUEST['values']['student_address']['MAIL']['CITY'] = $_REQUEST['values']['student_address']['HOME']['CITY'];
        $_REQUEST['values']['student_address']['MAIL']['ZIPCODE'] = $_REQUEST['values']['student_address']['HOME']['ZIPCODE'];
        $_REQUEST['values']['student_address']['MAIL']['STATE'] = $_REQUEST['values']['student_address']['HOME']['STATE'];
    }
    if ($_REQUEST['same_addr'] == 'Y') {

        $address_details = DBGEt(DBQuery('SELECT STREET_ADDRESS_1 as ADDRESS,STREET_ADDRESS_2 as STREET,CITY,STATE,ZIPCODE FROM  student_address WHERE COLLEGE_ROLL_NO=' . $_REQUEST['college_roll_no'] . ' AND type=\'Home Address\' '));
        if (isset($_REQUEST['values']['student_address']['HOME']['STREET_ADDRESS_1']) && !isset($_REQUEST['values']['student_address']['MAIL']['STREET_ADDRESS_1']))
            $_REQUEST['values']['student_address']['MAIL']['STREET_ADDRESS_1'] = $_REQUEST['values']['student_address']['HOME']['STREET_ADDRESS_1'];
        elseif (isset($_REQUEST['values']['student_address']['MAIL']['STREET_ADDRESS_1']) && $_REQUEST['values']['student_address']['MAIL']['STREET_ADDRESS_1']!='')
            $_REQUEST['values']['student_address']['MAIL']['STREET_ADDRESS_1'] = $_REQUEST['values']['student_address']['MAIL']['STREET_ADDRESS_1'];
        else
            $_REQUEST['values']['student_address']['MAIL']['STREET_ADDRESS_1'] = $address_details[1]['ADDRESS'];

        if (isset($_REQUEST['values']['student_address']['HOME']['STREET_ADDRESS_2']) && !isset($_REQUEST['values']['student_address']['MAIL']['STREET_ADDRESS_2']))
            $_REQUEST['values']['student_address']['MAIL']['STREET_ADDRESS_2'] = $_REQUEST['values']['student_address']['HOME']['STREET_ADDRESS_1'];
        elseif (isset($_REQUEST['values']['student_address']['MAIL']['STREET_ADDRESS_2']) && $_REQUEST['values']['student_address']['MAIL']['STREET_ADDRESS_2']!='') {
            $_REQUEST['values']['student_address']['MAIL']['STREET_ADDRESS_2'] = $_REQUEST['values']['student_address']['MAIL']['STREET_ADDRESS_2'];
        } else {
            $_REQUEST['values']['student_address']['MAIL']['STREET_ADDRESS_2'] = $address_details[1]['STREET'];
        }
        if (isset($_REQUEST['values']['student_address']['HOME']['CITY']) && !isset($_REQUEST['values']['student_address']['MAIL']['CITY']))
            $_REQUEST['values']['student_address']['MAIL']['CITY'] = $_REQUEST['values']['student_address']['HOME']['CITY'];
        elseif (isset($_REQUEST['values']['student_address']['MAIL']['CITY']) && $_REQUEST['values']['student_address']['MAIL']['CITY']!='')
            $_REQUEST['values']['student_address']['MAIL']['CITY'] = $_REQUEST['values']['student_address']['MAIL']['CITY'];
        else
            $_REQUEST['values']['student_address']['MAIL']['CITY'] = $address_details[1]['CITY'];

        if (isset($_REQUEST['values']['student_address']['HOME']['ZIPCODE']) && !isset($_REQUEST['values']['student_address']['MAIL']['ZIPCODE']))
            $_REQUEST['values']['student_address']['MAIL']['ZIPCODE'] = $_REQUEST['values']['student_address']['HOME']['ZIPCODE'];
        elseif (isset($_REQUEST['values']['student_address']['MAIL']['ZIPCODE']) && $_REQUEST['values']['student_address']['MAIL']['ZIPCODE']!='')
            $_REQUEST['values']['student_address']['MAIL']['ZIPCODE'] = $_REQUEST['values']['student_address']['MAIL']['ZIPCODE'];
        else
            $_REQUEST['values']['student_address']['MAIL']['ZIPCODE'] = $address_details[1]['ZIPCODE'];

        if (isset($_REQUEST['values']['student_address']['HOME']['STATE']) && !isset($_REQUEST['values']['student_address']['MAIL']['STATE']))
            $_REQUEST['values']['student_address']['MAIL']['STATE'] = $_REQUEST['values']['student_address']['HOME']['STATE'];
        elseif (isset($_REQUEST['values']['student_address']['MAIL']['STATE']) && $_REQUEST['values']['student_address']['MAIL']['STATE']!='')
            $_REQUEST['values']['student_address']['MAIL']['STATE'] = $_REQUEST['values']['student_address']['MAIL']['STATE'];
        else
            $_REQUEST['values']['student_address']['MAIL']['STATE'] = $address_details[1]['STATE'];
    }

    if ($_REQUEST['sec_addr'] == 'Y') {

        $address_details = DBGEt(DBQuery('SELECT STREET_ADDRESS_1 as ADDRESS,STREET_ADDRESS_2 as STREET,CITY,STATE,ZIPCODE FROM  student_address WHERE COLLEGE_ROLL_NO=' . $_REQUEST['college_roll_no'] . ' AND type=\'Home Address\' '));
        if (isset($_REQUEST['values']['student_address']['HOME']['STREET_ADDRESS_1']) && !isset($_REQUEST['values']['student_address']['SECONDARY']['STREET_ADDRESS_1']))
            $_REQUEST['values']['student_address']['SECONDARY']['STREET_ADDRESS_1'] = $_REQUEST['values']['student_address']['HOME']['STREET_ADDRESS_1'];
        elseif (isset($_REQUEST['values']['student_address']['SECONDARY']['STREET_ADDRESS_1']) && $_REQUEST['values']['student_address']['SECONDARY']['STREET_ADDRESS_1']!='')
            $_REQUEST['values']['student_address']['SECONDARY']['STREET_ADDRESS_1'] = $_REQUEST['values']['student_address']['SECONDARY']['STREET_ADDRESS_1'];
        else
            $_REQUEST['values']['student_address']['SECONDARY']['STREET_ADDRESS_1'] = $address_details[1]['ADDRESS'];

        if (isset($_REQUEST['values']['student_address']['HOME']['STREET_ADDRESS_2']) && !isset($_REQUEST['values']['student_address']['SECONDARY']['STREET_ADDRESS_2']))
            $_REQUEST['values']['student_address']['SECONDARY']['STREET_ADDRESS_2'] = $_REQUEST['values']['student_address']['HOME']['STREET_ADDRESS_1'];
        elseif (isset($_REQUEST['values']['student_address']['SECONDARY']['STREET_ADDRESS_2']) && $_REQUEST['values']['student_address']['SECONDARY']['STREET_ADDRESS_2']!='')
            $_REQUEST['values']['student_address']['SECONDARY']['STREET_ADDRESS_2'] = $_REQUEST['values']['student_address']['SECONDARY']['STREET_ADDRESS_2'];
        else
            $_REQUEST['values']['student_address']['SECONDARY']['STREET_ADDRESS_2'] = $address_details[1]['STREET'];

        if (isset($_REQUEST['values']['student_address']['HOME']['CITY']) && !isset($_REQUEST['values']['student_address']['SECONDARY']['CITY']))
            $_REQUEST['values']['student_address']['SECONDARY']['CITY'] = $_REQUEST['values']['student_address']['HOME']['CITY'];
        elseif (isset($_REQUEST['values']['student_address']['SECONDARY']['CITY']) && $_REQUEST['values']['student_address']['SECONDARY']['CITY']!='')
            $_REQUEST['values']['student_address']['SECONDARY']['CITY'] = $_REQUEST['values']['student_address']['SECONDARY']['CITY'];
        else
            $_REQUEST['values']['student_address']['SECONDARY']['CITY'] = $address_details[1]['CITY'];

        if (isset($_REQUEST['values']['student_address']['HOME']['ZIPCODE']) && !isset($_REQUEST['values']['student_address']['SECONDARY']['ZIPCODE']))
            $_REQUEST['values']['student_address']['SECONDARY']['ZIPCODE'] = $_REQUEST['values']['student_address']['HOME']['ZIPCODE'];
        elseif (isset($_REQUEST['values']['student_address']['SECONDARY']['ZIPCODE']) && $_REQUEST['values']['student_address']['SECONDARY']['ZIPCODE']!='')
            $_REQUEST['values']['student_address']['SECONDARY']['ZIPCODE'] = $_REQUEST['values']['student_address']['SECONDARY']['ZIPCODE'];
        else
            $_REQUEST['values']['student_address']['SECONDARY']['ZIPCODE'] = $address_details[1]['ZIPCODE'];

        if (isset($_REQUEST['values']['student_address']['HOME']['STATE']) && !isset($_REQUEST['values']['student_address']['SECONDARY']['STATE']))
            $_REQUEST['values']['student_address']['SECONDARY']['STATE'] = $_REQUEST['values']['student_address']['HOME']['STATE'];
        elseif (isset($_REQUEST['values']['student_address']['SECONDARY']['STATE']) && $_REQUEST['values']['student_address']['SECONDARY']['STATE']!='')
            $_REQUEST['values']['student_address']['SECONDARY']['STATE'] = $_REQUEST['values']['student_address']['SECONDARY']['STATE'];
        else
            $_REQUEST['values']['student_address']['SECONDARY']['STATE'] = $address_details[1]['STATE'];
    }
    if ($_REQUEST['prim_addr'] == 'Y') {

        $address_details = DBGEt(DBQuery('SELECT STREET_ADDRESS_1 as ADDRESS,STREET_ADDRESS_2 as STREET,CITY,STATE,ZIPCODE FROM  student_address WHERE COLLEGE_ROLL_NO=' . $_REQUEST['college_roll_no'] . ' AND type=\'Home Address\' '));
        if (isset($_REQUEST['values']['student_address']['HOME']['STREET_ADDRESS_1']) && !isset($_REQUEST['values']['student_address']['PRIMARY']['STREET_ADDRESS_1']))
            $_REQUEST['values']['student_address']['PRIMARY']['STREET_ADDRESS_1'] = $_REQUEST['values']['student_address']['HOME']['STREET_ADDRESS_1'];
        elseif (isset($_REQUEST['values']['student_address']['PRIMARY']['STREET_ADDRESS_1']) && $_REQUEST['values']['student_address']['PRIMARY']['STREET_ADDRESS_1']!='')
            $_REQUEST['values']['student_address']['PRIMARY']['STREET_ADDRESS_1'] = $_REQUEST['values']['student_address']['PRIMARY']['STREET_ADDRESS_1'];
        else
            $_REQUEST['values']['student_address']['PRIMARY']['STREET_ADDRESS_1'] = $address_details[1]['ADDRESS'];

        if (isset($_REQUEST['values']['student_address']['HOME']['STREET_ADDRESS_2']) && !isset($_REQUEST['values']['student_address']['PRIMARY']['STREET_ADDRESS_2']))
            $_REQUEST['values']['student_address']['PRIMARY']['STREET_ADDRESS_2'] = $_REQUEST['values']['student_address']['HOME']['STREET_ADDRESS_2'];
        elseif (isset($_REQUEST['values']['student_address']['PRIMARY']['STREET_ADDRESS_2']) && $_REQUEST['values']['student_address']['PRIMARY']['STREET_ADDRESS_2']!='')
            $_REQUEST['values']['student_address']['PRIMARY']['STREET_ADDRESS_2'] = $_REQUEST['values']['student_address']['PRIMARY']['STREET_ADDRESS_2'];
        else
            $_REQUEST['values']['student_address']['PRIMARY']['STREET_ADDRESS_2'] = $address_details[1]['STREET'];

        if (isset($_REQUEST['values']['student_address']['HOME']['CITY']) & !isset($_REQUEST['values']['student_address']['PRIMARY']['CITY']))
            $_REQUEST['values']['student_address']['PRIMARY']['CITY'] = $_REQUEST['values']['student_address']['HOME']['CITY'];
        elseif (isset($_REQUEST['values']['student_address']['PRIMARY']['CITY']) && $_REQUEST['values']['student_address']['PRIMARY']['CITY']!='')
            $_REQUEST['values']['student_address']['PRIMARY']['CITY'] = $_REQUEST['values']['student_address']['PRIMARY']['CITY'];
        else
            $_REQUEST['values']['student_address']['PRIMARY']['CITY'] = $address_details[1]['CITY'];

        if (isset($_REQUEST['values']['student_address']['HOME']['ZIPCODE']) && !isset($_REQUEST['values']['student_address']['PRIMARY']['ZIPCODE']))
            $_REQUEST['values']['student_address']['PRIMARY']['ZIPCODE'] = $_REQUEST['values']['student_address']['HOME']['ZIPCODE'];
        elseif (isset($_REQUEST['values']['student_address']['PRIMARY']['ZIPCODE']) && $_REQUEST['values']['student_address']['PRIMARY']['ZIPCODE']!='')
            $_REQUEST['values']['student_address']['PRIMARY']['ZIPCODE'] = $_REQUEST['values']['student_address']['PRIMARY']['ZIPCODE'];
        else
            $_REQUEST['values']['student_address']['PRIMARY']['ZIPCODE'] = $address_details[1]['ZIPCODE'];

        if (isset($_REQUEST['values']['student_address']['HOME']['STATE']) && !isset($_REQUEST['values']['student_address']['PRIMARY']['STATE']))
            $_REQUEST['values']['student_address']['PRIMARY']['STATE'] = $_REQUEST['values']['student_address']['HOME']['STATE'];
        elseif (isset($_REQUEST['values']['student_address']['PRIMARY']['STATE']) && $_REQUEST['values']['student_address']['PRIMARY']['STATE']!='')
            $_REQUEST['values']['student_address']['PRIMARY']['STATE'] = $_REQUEST['values']['student_address']['PRIMARY']['STATE'];
        else
            $_REQUEST['values']['student_address']['PRIMARY']['STATE'] = $address_details[1]['STATE'];
    }

    if ($_REQUEST['r6'] == 'Y') {
        $_REQUEST['values']['student_address']['SECONDARY']['STREET_ADDRESS_1'] = $_REQUEST['values']['student_address']['HOME']['STREET_ADDRESS_1'];
        $_REQUEST['values']['student_address']['SECONDARY']['STREET_ADDRESS_2'] = $_REQUEST['values']['student_address']['HOME']['STREET_ADDRESS_2'];
        $_REQUEST['values']['student_address']['SECONDARY']['CITY'] = $_REQUEST['values']['student_address']['HOME']['CITY'];
        $_REQUEST['values']['student_address']['SECONDARY']['ZIPCODE'] = $_REQUEST['values']['student_address']['HOME']['ZIPCODE'];
        $_REQUEST['values']['student_address']['SECONDARY']['STATE'] = $_REQUEST['values']['student_address']['HOME']['STATE'];
    }

    if ($_REQUEST['r5'] == 'Y') {
        $_REQUEST['values']['student_address']['PRIMARY']['STREET_ADDRESS_1'] = $_REQUEST['values']['student_address']['HOME']['STREET_ADDRESS_1'];
        $_REQUEST['values']['student_address']['PRIMARY']['STREET_ADDRESS_2'] = $_REQUEST['values']['student_address']['HOME']['STREET_ADDRESS_2'];
        $_REQUEST['values']['student_address']['PRIMARY']['CITY'] = $_REQUEST['values']['student_address']['HOME']['CITY'];
        $_REQUEST['values']['student_address']['PRIMARY']['ZIPCODE'] = $_REQUEST['values']['student_address']['HOME']['ZIPCODE'];
        $_REQUEST['values']['student_address']['PRIMARY']['STATE'] = $_REQUEST['values']['student_address']['HOME']['STATE'];
    }

    foreach ($_REQUEST['values'] as $table => $type) {
        foreach ($type as $ind => $val) {
            if ($val['ID'] != 'new') {
                $go = 'false';
                $cond_go = 'false';

                if ($val['PROFILE_ID'] != '') {
                    $staff_info_sql = "SELECT PROFILE_ID FROM people WHERE STAFF_ID=" . $val['ID'];
                    $staff_info = DBGet(DBQuery($staff_info_sql));
                    $staff_prof_id = $staff_info[1]['PROFILE_ID'];

                    $update_sql = 'UPDATE login_authentication SET PROFILE_ID =\'' . $val['PROFILE_ID'] . '\' WHERE USER_ID = ' . $val['ID'] . ' AND PROFILE_ID = ' . $staff_prof_id;
                    DBQuery($update_sql);
                }
                foreach ($val as $col => $col_v) {

                    if ($col != 'ID') {
                        if ($col == 'PASSWORD' && $col_v != '') {
                            $password = md5(singleQuoteReplace('', '', $col_v));
                        } elseif ($col == 'USER_NAME' && $col_v != '') {
                            $user_name_val = singleQuoteReplace('', '', $col_v);
                        } elseif ($col == 'RELATIONSHIP' && $col_v != '')
                            $rel_stu[] = $col . '=\'' . singleQuoteReplace('', '', $col_v) . '\'';
                        elseif ($col == 'IS_EMERGENCY_HIDDEN' && $col_v == 'Y')
                            $rel_stu[] = 'IS_EMERGENCY=\'' . singleQuoteReplace('', '', $col_v) . '\'';
                        elseif ($col == 'IS_EMERGENCY_HIDDEN' && $col_v == 'N')
                            $rel_stu[] = 'IS_EMERGENCY=NULL';
                        else {
                            if ($col != 'USER_NAME' && $col != 'RELATIONSHIP' && $col != 'PASSWORD' && $col != 'IS_EMERGENCY' && $col != 'IS_EMERGENCY_HIDDEN')
                                $set_arr[] = $col . "='" . singleQuoteReplace('', '', $col_v) . "'";
                        }
                        $go = 'true';
                    }

                    if ($col == 'ID' && $col_v != '') {
                        if ($table == 'people') {
                            $where = 'STAFF_ID=' . $col_v;

                            if ($ind == 'PRIMARY') {
                                if ($_REQUEST['selected_pri_parent'] != '' && $col_v != $_REQUEST['selected_pri_parent']) {
                                    $rel_stu[] = 'PERSON_ID=\'' . $_REQUEST['selected_pri_parent'] . '\'';
                                }
                                $pri_up_pl_id = $col_v;
                            }
                            if ($ind == 'SECONDARY') {
                                if ($_REQUEST['selected_sec_parent'] != '' && $col_v != $_REQUEST['selected_sec_parent']) {
                                    $rel_stu[] = 'PERSON_ID=\'' . $_REQUEST['selected_sec_parent'] . '\'';
                                }
                                $sec_up_pl_id = $col_v;
                            }
                            if ($ind == 'OTHER') {
                                if ($_REQUEST['selected_oth_parent'] != '' && $col_v != $_REQUEST['selected_oth_parent']) {
                                    $rel_stu[] = 'PERSON_ID=\'' . $_REQUEST['selected_oth_parent'] . '\'';
                                }
                                $oth_up_pl_id = $col_v;
                            }
                        } else {
                            $where = ' ID=' . $col_v;
                        }
                        $cond_go = 'true';
                    }
                }


                $set_arr = implode(',', $set_arr);
                $rel_stu = implode(',', $rel_stu);
                if ($set_arr != '') {
                    if ($table == 'student_address') {

                        if (strpos($set_arr, 'BUS_PICKUP') == '')
                            $set_arr .= ',BUS_PICKUP=NULL';
                        if (strpos($set_arr, 'BUS_DROPOFF') == '')
                            $set_arr .= ',BUS_DROPOFF=NULL';
                    }
                    if ($table == 'people') {
                        if (strpos($set_arr, 'CUSTODY') == '')
                            $set_arr .= ',CUSTODY=NULL';
                    }

                    $qry = 'UPDATE ' . $table . ' SET ' . $set_arr . ' WHERE ' . $where;
                }
                //codes to be inserted
                if ($qry != '')
                    DBQuery($qry);
                if ($ind == 'PRIMARY' && $rel_stu != '') {
                    DBQuery('UPDATE students_join_people SET ' . $rel_stu . ' WHERE EMERGENCY_TYPE=\'Primary\' AND PERSON_ID=' . $pri_up_pl_id . ' AND COLLEGE_ROLL_NO=' . UserStudentID());
                }
                if ($ind == 'SECONDARY' && $rel_stu != '') {
                    DBQuery('UPDATE students_join_people SET ' . $rel_stu . ' WHERE EMERGENCY_TYPE=\'Secondary\' AND PERSON_ID=' . $sec_up_pl_id . ' AND COLLEGE_ROLL_NO=' . UserStudentID());
                }
                if ($ind == 'OTHER' && $rel_stu != '') {
                    DBQuery('UPDATE students_join_people SET ' . $rel_stu . ' WHERE EMERGENCY_TYPE=\'Other\' AND PERSON_ID=' . $oth_up_pl_id . ' AND COLLEGE_ROLL_NO=' . UserStudentID());
                }
                if ($table == 'people' && $ind == 'PRIMARY') {
                    if (clean_param($_REQUEST['primary_portal'], PARAM_ALPHAMOD) == 'Y' && $password != '') {

                        $res_pass_chk = DBQuery('SELECT * FROM login_authentication WHERE PASSWORD=\'' . $password . '\'');
                        $res_user_chk = DBQuery('SELECT * FROM login_authentication WHERE USERNAME=\'' . $user_name_val . '\'');
                        $num_user = DBGet($res_user_chk);
                        $num_pass = DBGet($res_pass_chk);

                        if (count($num_user) == 0) {
                            if (count($num_pass) == 0) {


                                DBQuery('INSERT INTO login_authentication (USER_ID,USERNAME,PASSWORD,PROFILE_ID) VALUES (' . $pri_up_pl_id . ',\'' . $user_name_val . '\',\'' . $password . '\',4)');
                            } else {
                                echo "<script>document.getElementById('divErr').innerHTML='<font color=red><b>Password already exists.</b></font>';</script>";
                            }
                        } else {
                            echo "<script>document.getElementById('divErr').innerHTML='<font color=red><b>Username already exists.</b></font>';</script>";
                        }
                    }
                }
                if ($table == 'people' && $ind == 'SECONDARY') {
                    if (clean_param($_REQUEST['secondary_portal'], PARAM_ALPHAMOD) == 'Y' && $password != '') {
                        $res_user_chk = DBQuery('SELECT * FROM login_authentication WHERE USERNAME=\'' . $user_name_val . '\'');
                        $num_user = DBGet($res_user_chk);
                        $res_pass_chk = DBQuery('SELECT * FROM login_authentication WHERE PASSWORD=\'' . $password . '\'');
                        $num_pass = DBGet($res_pass_chk);

                        if (count($num_user) == 0) {
                            if (count($num_pass) == 0) {

                                DBQuery('INSERT INTO login_authentication (USER_ID,USERNAME,PASSWORD,PROFILE_ID) VALUES (' . $sec_up_pl_id . ',\'' . $user_name_val . '\',\'' . $password . '\',4)');
                            } else {

                                echo "<script>document.getElementById('divErr').innerHTML='<font color=red><b>Password already exists.</b></font>';</script>";
                            }
                        } else {
                            echo "<script>document.getElementById('divErr').innerHTML='<font color=red><b>Username already exists.</b></font>';</script>";
                        }
                    }
                }
                if ($table == 'people' && $ind == 'OTHER') {
                    if (clean_param($_REQUEST['other_portal'], PARAM_ALPHAMOD) == 'Y' && $password != '') {
                        $res_user_chk = DBQuery('SELECT * FROM login_authentication WHERE USERNAME=\'' . $user_name_val . '\'');
                        $num_user = DBGet($res_user_chk);
                        $res_pass_chk = DBQuery('SELECT * FROM login_authentication WHERE PASSWORD=\'' . $password . '\'');
                        $num_pass = DBGet($res_pass_chk);
                        if (count($num_user) == 0) {
                            if (count($num_pass) == 0) {

                                DBQuery('INSERT INTO login_authentication (USER_ID,USERNAME,PASSWORD,PROFILE_ID) VALUES (' . $oth_up_pl_id . ',\'' . $user_name_val . '\',\'' . $password . '\',4)');
                            } else {

                                echo "<script>document.getElementById('divErr').innerHTML='<font color=red><b>Password already exists.</b></font>';</script>";
                            }
                        } else {
                            echo "<script>document.getElementById('divErr').innerHTML='<font color=red><b>Username already exists.</b></font>';</script>";
                        }
                    }
                }
                unset($set_arr);
                unset($where);
                unset($col);
                unset($col_v);
                unset($go);
                unset($cond_go);
                unset($password);
                unset($user_name_val);
                unset($rel_stu);

                $get_person_ids = DBGet(DBQuery('SELECT * FROM students_join_people WHERE COLLEGE_ROLL_NO=' . UserStudentID() . ''));
                foreach ($get_person_ids as $gpi => $gpd) {
                    if ($gpd['EMERGENCY_TYPE'] != 'Other')
                        DBQuery('UPDATE student_address SET PEOPLE_ID=' . $gpd['PERSON_ID'] . ' WHERE TYPE=\'' . $gpd['EMERGENCY_TYPE'] . '\' AND COLLEGE_ROLL_NO=' . UserStudentID());
                }
            }
            else {
                $pri_pep_exists = 'N';
                $sec_pep_exists = 'N';
                $oth_pep_exists = 'N';
                if ($ind == 'PRIMARY' || $ind == 'SECONDARY') {
                    $pri_people_exists = DBGet(DBQuery('SELECT * FROM people WHERE FIRST_NAME=\'' . singleQuoteReplace('', '', $_REQUEST['values']['people']['PRIMARY']['FIRST_NAME']) . '\' AND LAST_NAME=\'' . singleQuoteReplace('', '', $_REQUEST['values']['people']['PRIMARY']['LAST_NAME']) . '\' AND EMAIL=\'' . $_REQUEST['values']['people']['PRIMARY']['EMAIL'] . '\''));
//                    if(count($pri_people_exists)>0)
                    if ($_REQUEST['hidden_primary'] != '') {

                        $pri_person_id = $_REQUEST['hidden_primary'];
                        $pri_pep_exists = 'Y';
                    } else {
                        $id = DBGet(DBQuery("SHOW TABLE STATUS LIKE 'people'"));
                        $pri_person_id = $id[1]['AUTO_INCREMENT'];
                    }
                    $sec_people_exists = DBGet(DBQuery('SELECT * FROM people WHERE FIRST_NAME=\'' . singleQuoteReplace('', '', $_REQUEST['values']['people']['SECONDARY']['FIRST_NAME']) . '\' AND LAST_NAME=\'' . singleQuoteReplace('', '', $_REQUEST['values']['people']['SECONDARY']['LAST_NAME']) . '\' AND EMAIL=\'' . singleQuoteReplace('', '', $_REQUEST['values']['people']['SECONDARY']['EMAIL']) . '\''));
                    
                        if($_REQUEST['values']['people']['SECONDARY']['FIRST_NAME']=='' && $_REQUEST['values']['people']['SECONDARY']['LAST_NAME']=='')
                        {
                            $sec_pep_exists = 'Y';
                        }
// if(count($sec_people_exists)>0)
                    if ($_REQUEST['hidden_secondary'] != '') {
                        $sec_person_id = $_REQUEST['hidden_secondary'];
                        $sec_pep_exists = 'Y';
                    } else {
                        $id = DBGet(DBQuery("SHOW TABLE STATUS LIKE 'people'"));
                        $sec_person_id = $id[1]['AUTO_INCREMENT'];
                    }
                }
                if ($ind == 'OTHER' && $table == 'people') {
                    $oth_people_exists = DBGet(DBQuery('SELECT * FROM people WHERE FIRST_NAME=\'' . singleQuoteReplace('', '', $_REQUEST['values']['people']['OTHER']['FIRST_NAME']) . '\' AND LAST_NAME=\'' . singleQuoteReplace('', '', $_REQUEST['values']['people']['OTHER']['LAST_NAME']) . '\' AND EMAIL=\'' . singleQuoteReplace('', '', $_REQUEST['values']['people']['OTHER']['EMAIL']) . '\''));
//                    if(count($oth_people_exists)>0)
//                    {
                    if ($_REQUEST['hidden_other'] != '') {
                        $oth_person_id = $_REQUEST['hidden_other'];
                        $oth_pep_exists = 'Y';
                    } else {
                        $id = DBGet(DBQuery("SHOW TABLE STATUS LIKE 'people'"));
                        $oth_person_id = $id[1]['AUTO_INCREMENT'];
                    }
                }
                $go = 'false';
                $log_go = false;
                foreach ($val as $col => $col_v) {
                    if ($table == 'student_address') {
                        if ($col != 'ID' && $col_v != '') {
                            $fields[] = $col;

                            $field_vals[] = "'" . singleQuoteReplace('', '', $col_v) . "'";

                            $go = 'true';
                        }
                    }
                    if ($table == 'people') {
                        if ($col != 'ID' && $col_v != '') {
                            if ($col == 'RELATIONSHIP' || $col == 'IS_EMERGENCY') {
                                $sjp_field .= $col . ',';
                                $sjp_value .= "'" . $col_v . "',";
                            } else {
                                if ($col != 'PASSWORD' && $col != 'USER_NAME' && $col != 'IS_EMERGENCY_HIDDEN') {
                                    $peo_fields[] = $col;
                                    $peo_field_vals[] = "'" . singleQuoteReplace('', '', $col_v) . "'";
                                    $log_go = true;
                                }
                            }
                        }
                    }
                }
                $fields = implode(',', $fields);
                $field_vals = implode(',', $field_vals);
                $peo_fields = implode(',', $peo_fields);
                $peo_field_vals = implode(',', $peo_field_vals);
                if ($table == 'student_address') {
                    if ($ind == 'PRIMARY' || $ind == 'SECONDARY' || $ind == 'OTHER')
                        $type_n = 'type,people_id';
                    else
                        $type_n = 'type';
                }
                if ($ind == 'HOME')
                    $ind_n = "'Home Address'";
                if ($ind == 'PRIMARY')
                    $ind_n = "'Primary'," . $pri_person_id . "";
                if ($ind == 'SECONDARY')
                    $ind_n = "'Secondary'," . $sec_person_id . "";
                if ($ind == 'OTHER')
                    $ind_n = "'Other'," . $oth_person_id . "";
                if ($ind == 'MAIL')
                    $ind_n = "'Mail'";


                if ($table == 'student_address') {
                    if ($ind == 'HOME' || $ind == 'MAIL')
                        $qry = 'INSERT INTO ' . $table . ' (college_roll_no,syear,college_id,' . $fields . ',' . $type_n . ') VALUES (' . UserStudentID() . ',' . UserSyear() . ',' . UserCollege() . ',' . $field_vals . ',' . $ind_n . ') ';
                    if (($ind == 'PRIMARY') || ($ind == 'SECONDARY') || ($ind == 'OTHER'))
                    {
                       if($fields!='' && substr($fields,0,1)!=',')
                                $fields=','.$fields;
                        if($field_vals!='' && substr($field_vals,0,1)!=',')
                           $field_vals=','.$field_vals; 
                        if($ind == 'SECONDARY' && $_REQUEST['values']['people']['SECONDARY']['FIRST_NAME']!='' && $_REQUEST['values']['people']['SECONDARY']['LAST_NAME']!='')
                        {
                             $go = 'true';
                              $qry = 'INSERT INTO ' . $table . ' (college_roll_no,syear,college_id' . $fields . ',' . $type_n . ') VALUES (' . UserStudentID() . ',' . UserSyear() . ',' . UserCollege()  . $field_vals . ',' . $ind_n . ') ';
                        }
                                
                        if($ind != 'SECONDARY')
                            $qry = 'INSERT INTO ' . $table . ' (college_roll_no,syear,college_id' . $fields . ',' . $type_n . ') VALUES (' . UserStudentID() . ',' . UserSyear() . ',' . UserCollege()  . $field_vals . ',' . $ind_n . ') ';
                    }
                }
                if ($table == 'people') {
                    
                    if (($ind == 'PRIMARY' && $pri_pep_exists == 'N') || ($ind == 'SECONDARY' && $sec_pep_exists == 'N') || ($ind == 'OTHER' && $oth_pep_exists == 'N')) {
                        $sql_sjp = 'INSERT INTO students_join_people (' . $sjp_field . 'college_roll_no,emergency_type,person_id) VALUES (' . $sjp_value . UserStudentID() . ',' . $ind_n . ')';
                        $peo_fields_ar = explode(',', $peo_fields);
                        if (!in_array('PROFILE_ID', $peo_fields_ar)) {
                            $sql_peo = 'INSERT INTO people (CURRENT_COLLEGE_ID,profile,profile_id,' . $peo_fields . ') VALUES (' . UserCollege() . ',\'parent\',4,' . $peo_field_vals . ')';
                        } else {
                            $sql_peo = 'INSERT INTO people (CURRENT_COLLEGE_ID,profile,' . $peo_fields . ') VALUES (' . UserCollege() . ',\'parent\',' . $peo_field_vals . ')';
                        }
                    }
                }
                if ($go == 'true' & $qry != '')
                    
                    DBQuery($qry);

                if ($log_go) {
                    DBQuery($sql_sjp);

                    if (($ind == 'PRIMARY' && $pri_pep_exists == 'N') || ($ind == 'SECONDARY' && $sec_pep_exists == 'N') || ($ind == 'OTHER' && $oth_pep_exists == 'N'))
                        DBQuery($sql_peo);
                }

                if ($table == 'people' && $ind == 'PRIMARY' && $type['PRIMARY']['USER_NAME'] != '' && $pri_pep_exists == 'N') {
                    if (clean_param($_REQUEST['primary_portal'], PARAM_ALPHAMOD) == 'Y') {
                        $res_pass_chk = DBQuery('SELECT * FROM login_authentication WHERE PASSWORD = \'' . md5($type['PRIMARY']['PASSWORD']) . '\'');
                        $num_pass = DBGet($res_pass_chk);
                        $res_user_chk = DBQuery('SELECT * FROM login_authentication WHERE USERNAME = \'' . $type['PRIMARY']['USER_NAME'] . '\'');
                        $num_user = DBGet($res_user_chk);

                        if (count($num_user) == 0) {
                            if (count($num_pass) == 0) {
                                if ($_REQUEST['values']['people']['PRIMARY']['PROFILE_ID'] != '')
                                    $pri_prof_id = $_REQUEST['values']['people']['PRIMARY']['PROFILE_ID'];
                                else
                                    $pri_prof_id = 4;

                                DBQuery('INSERT INTO login_authentication (USER_ID,USERNAME,PASSWORD,PROFILE_ID) VALUES (' . $pri_person_id . ',\'' . $type['PRIMARY']['USER_NAME'] . '\',\'' . md5($type['PRIMARY']['PASSWORD']) . '\',' . $pri_prof_id . ')');
                            }
                            else {

                                echo "<script>document.getElementById('divErr').innerHTML='<font color=red><b>Password already exists.</b></font>';</script>";
                            }
                        } else {
                            echo "<script>document.getElementById('divErr').innerHTML='<font color=red><b>Username already exists.</b></font>';</script>";
                        }
                    }
                }
                if ($table == 'people' && $ind == 'SECONDARY' && $sec_pep_exists == 'N') {

                    if (clean_param($_REQUEST['secondary_portal'], PARAM_ALPHAMOD) == 'Y' && $type['SECONDARY']['USER_NAME'] != '') {
                        $res_pass_chk = DBQuery('SELECT * FROM login_authentication WHERE PASSWORD = \'' . md5($type['SECONDARY']['PASSWORD']) . '\'');
                        $num_pass = DBGet($res_pass_chk);

                        $res_user_chk = DBQuery('SELECT * FROM login_authentication WHERE USERNAME = \'' . $type['SECONDARY']['USER_NAME'] . '\'');
                        $num_user = DBGet($res_user_chk);
                        if (count($num_user) == 0) {
                            if (count($num_pass) == 0) {
                                if ($_REQUEST['values']['people']['SECONDARY']['PROFILE_ID'] != '')
                                    $sec_prof_id = $_REQUEST['values']['people']['SECONDARY']['PROFILE_ID'];
                                else
                                    $sec_prof_id = 4;

                                DBQuery('INSERT INTO login_authentication (USER_ID,USERNAME,PASSWORD,PROFILE_ID) VALUES (' . $sec_person_id . ',\'' . $type['SECONDARY']['USER_NAME'] . '\',\'' . md5($type['SECONDARY']['PASSWORD']) . '\',' . $sec_prof_id . ')');
                            }
                            else {

                                echo "<script>document.getElementById('divErr').innerHTML='<font color=red><b>Password already exists.</b></font>';</script>";
                            }
                        } else {
                            echo "<script>document.getElementById('divErr').innerHTML='<font color=red><b>Username already exists.</b></font>';</script>";
                        }
                    }
                }
                if ($table == 'people' && $ind == 'OTHER' && $oth_pep_exists == 'N') {
                    if (clean_param($_REQUEST['other_portal'], PARAM_ALPHAMOD) == 'Y' && $type['OTHER']['USER_NAME'] != '') {
                        $res_pass_chk = DBQuery('SELECT * FROM login_authentication WHERE PASSWORD = \'' . md5($type['OTHER']['PASSWORD']) . '\'');
                        $num_pass = DBGet($res_pass_chk);
                        $res_user_chk = DBQuery('SELECT * FROM login_authentication WHERE USERNAME = \'' . $type['OTHER']['USER_NAME'] . '\'');
                        $num_user = DBGet($res_user_chk);
                        if (count($num_user) == 0) {
                            if (count($num_pass) == 0) {
                                if ($_REQUEST['values']['people']['OTHER']['PROFILE_ID'] != '')
                                    $oth_prof_id = $_REQUEST['values']['people']['OTHER']['PROFILE_ID'];
                                else
                                    $oth_prof_id = 4;

                                DBQuery('INSERT INTO login_authentication (USER_ID,USERNAME,PASSWORD,PROFILE_ID) VALUES (' . $oth_person_id . ',\'' . $type['OTHER']['USER_NAME'] . '\',\'' . md5($type['OTHER']['PASSWORD']) . '\',' . $oth_prof_id . ')');
                            }
                            else {

                                echo "<script>document.getElementById('divErr').innerHTML='<font color=red><b>Password already exists.</b></font>';</script>";
                            }
                        } else {
                            echo "<script>document.getElementById('divErr').innerHTML='<font color=red><b>Username already exists.</b></font>';</script>";
                        }
                    }
                }

                unset($fields);
                unset($qry);
                unset($field_vals);
                unset($peo_fields);
                unset($peo_field_vals);
                unset($sjp_field);
                unset($sjp_value);
                unset($log_go);
                unset($where);
                unset($col);
                unset($col_v);
                unset($type_n);
                unset($ind_n);
                unset($go);
                $get_person_ids = DBGet(DBQuery('SELECT * FROM students_join_people WHERE COLLEGE_ROLL_NO=' . UserStudentID() . ''));
                foreach ($get_person_ids as $gpi => $gpd) {
                    if ($gpd['EMERGENCY_TYPE'] != 'Other')
                        DBQuery('UPDATE student_address SET PEOPLE_ID=' . $gpd['PERSON_ID'] . ' WHERE TYPE=\'' . $gpd['EMERGENCY_TYPE'] . '\' AND COLLEGE_ROLL_NO=' . UserStudentID());
                }
            }
        }
    }
}


if (clean_param($_REQUEST['modfunc'], PARAM_ALPHAMOD) == 'delete') {
    if ($_REQUEST['person_id']) {
        if (DeletePromptModContacts('contact')) {
            $tot_people = DBGet(DBQuery('SELECT COUNT(*) AS TOTAL FROM students_join_people WHERE PERSON_ID=' . $_REQUEST['person_id'] . ''));
            $tot_people = $tot_people[1]['TOTAL'];
            if ($tot_people > 1) {
                DBQuery('DELETE FROM students_join_people WHERE PERSON_ID=\'' . $_REQUEST['person_id'] . '\' AND COLLEGE_ROLL_NO=' . UserStudentID());
                unset($_REQUEST['modfunc']);
            } else {
                DBQuery('DELETE FROM student_address WHERE PEOPLE_ID=\'' . $_REQUEST['person_id'] . '\' AND COLLEGE_ROLL_NO=' . UserStudentID());
                DBQuery('DELETE FROM students_join_people WHERE PERSON_ID=\'' . $_REQUEST['person_id'] . '\' AND COLLEGE_ROLL_NO=' . UserStudentID());
                DBQuery('DELETE FROM people WHERE STAFF_ID=' . $_REQUEST['person_id']);
                DBQuery('DELETE FROM login_authentication WHERE USER_ID=' . $_REQUEST['person_id'] . ' AND PROFILE_ID=4');
                unset($_REQUEST['modfunc']);
            }
        }
    }
}

if (!$_REQUEST['modfunc']) {
    $addres_id = DBGet(DBQuery('SELECT ID AS ADDRESS_ID FROM student_address WHERE COLLEGE_ROLL_NO=\'' . UserStudentID() . '\' AND SYEAR=\'' . UserSyear() . '\' AND COLLEGE_ID=\'' . UserCollege() . '\' AND TYPE=\'Home Address\' '));
    if (count($addres_id) == 1 && $addres_id[1]['ADDRESS_ID'] != '')
        $_REQUEST['address_id'] = $addres_id[1]['ADDRESS_ID'];


    echo '<div class="row">';
    echo '<div class="col-md-12">';
    echo '<ul class="list-group">'; // table 3
    ############################################################################################

    $style = '';
    if ($_REQUEST['person_id'] == 'new') {
        if ($_REQUEST['address_id'] != 'new')
            echo '<li class="list-group-item" onclick="document.location.href=\'Modules.php?modname=' . $_REQUEST['modname'] . '&include=' . $_REQUEST['include'] . '&address_id=' . $_REQUEST['address_id'] . '\';" >';
        else
            echo '<li class="list-group-item" onclick="document.location.href=\'Modules.php?modname=' . $_REQUEST['modname'] . '&include=' . $_REQUEST['include'] . '&address_id=new\';" >';
        echo '<A style="cursor:pointer"><b>Student\'s Address </b>';
    }
    else {
        if ($_REQUEST['person_id'] == $contact['PERSON_ID'])
            $active = 'active';
        elseif ($_REQUEST['person_id'] != $contact['PERSON_ID'])
            $active = '';
        else
            $active = 'active';
        echo '<li class="list-group-item ' . $active . '" onclick="document.location.href=\'Modules.php?modname=' . $_REQUEST['modname'] . '&include=' . $_REQUEST['include'] . '&address_id=$_REQUEST[address_id]\';" onmouseover=\'this.style.color="white";\'>';
        echo '<a href="javascript:void(0);" onclick="document.location.href=\'Modules.php?modname=' . $_REQUEST['modname'] . '&include=' . $_REQUEST['include'] . '&address_id=$_REQUEST[address_id]\';">';
        echo 'Student\'s Address';
    }
    echo '</a>' . (($active != '') ? '<span class="text-slate pull-right"><i class="icon-arrow-right13"></i></span>' : '');
    echo '</li>';



    $contacts_RET = DBGet(DBQuery('SELECT PERSON_ID,RELATIONSHIP AS STUDENT_RELATION FROM students_join_people WHERE COLLEGE_ROLL_NO=\'' . UserStudentID() . '\' AND EMERGENCY_TYPE=\'Other\' ORDER BY STUDENT_RELATION'));
    $i = 1;
    if (count($contacts_RET)) {
        foreach ($contacts_RET as $contact) {
            $THIS_RET = $contact;

            $style .= ' ';

            $i++;
            $link = 'onclick="document.location.href=\'Modules.php?modname=' . $_REQUEST['modname'] . '&include=' . $_REQUEST['include'] . '&address_id=' . $_REQUEST['address_id'] . '&person_id=' . $contact['PERSON_ID'] . '&con_info=old\';"';
            if (AllowEdit())
            //$remove_button = button('remove', '', "Modules.php?modname=$_REQUEST[modname]&include=$_REQUEST[include]&modfunc=delete&address_id=$_REQUEST[address_id]&person_id=$contact[PERSON_ID]", 20, 'style="float:right;"');
                $remove_button = '<a class="pull-right text-danger" href="Modules.php?modname=' . $_REQUEST["modname"] . '&include=' . $_REQUEST["include"] . '&modfunc=delete&address_id=' . $_REQUEST["address_id"] . '&person_id=' . $contact["PERSON_ID"] . '" onclick="grabA(this); return false;"><i class="icon-cancel-square2"></i></a>';
            else
                $remove_button = '';

            /* if ($_REQUEST['person_id'] == $contact['PERSON_ID'])
              echo '<li>' . $remove_button . '<a ' . $link . ' ' . $style . '>';
              else
              echo '<li>' . $remove_button . '<a ' . $link . ' ' . $style . '>'; */

            $images = '';



            if ($contact['CUSTODY'] == 'Y')
                $images .= ' <IMG SRC=assets/gavel_button.gif>';
            if ($contact['EMERGENCY'] == 'Y')
                $images .= ' <IMG SRC=assets/emergency_button.gif>';
            if ($_REQUEST['person_id'] == $contact['PERSON_ID']) {
                echo '<li class="list-group-item active" >' . '<A ' . $link . ' >' . ($contact['STUDENT_RELATION'] ? $contact['STUDENT_RELATION'] : '---') . '' . $images . '</A>' . '<span class="text-slate pull-right m-l-10"><i class="icon-arrow-right13"></i></span>' . $remove_button;
            } else {
                echo '<li class="list-group-item">' . '<A ' . $link . '>' . ($contact['STUDENT_RELATION'] ? $contact['STUDENT_RELATION'] : '---') . '' . $images . '</A>' . $remove_button;
            }
            echo '</li>';
        }
    }
    ############################################################################################	
    // New Address
    if (AllowEdit()) {
        /* if ($_REQUEST['address_id'] !== 'new' && $_REQUEST['address_id'] !== 'old') {

          echo '<TABLE width=100%><TR><TD>';
          if ($_REQUEST['address_id'] == 0)
          echo '<TABLE border=0 cellpadding=0 cellspacing=0 width=100%>';
          else
          echo '<TABLE border=0 cellpadding=0 cellspacing=0 width=100%>';
          // New Contact
          if (AllowEdit()) {
          $style = 'class=break';
          }

          echo '</TABLE>';
          } */

        $check_address = DBGet(DBQuery('SELECT COUNT(*) as REC_EX FROM students_join_people WHERE COLLEGE_ROLL_NO=' . UserStudentID()));
        if ($check_address[1]['REC_EX'] > 1) {
            if (clean_param($_REQUEST['person_id'], PARAM_ALPHAMOD) == 'new') {
                echo '<li class="list-group-item active"><a href="javascript:void(0);" onclick="document.location.href=\'Modules.php?modname=' . $_REQUEST['modname'] . '&include=' . $_REQUEST['include'] . '&address_id=' . $_REQUEST['address_id'] . '&person_id=new&con_info=old\';">';
                echo '<i class="icon-plus2"></i> Add New Contact</A><li>';
            } else {
                echo '<li class="list-group-item"><a href="javascript:void(0);" onclick="document.location.href=\'Modules.php?modname=' . $_REQUEST['modname'] . '&include=' . $_REQUEST['include'] . '&address_id=' . $_REQUEST['address_id'] . '&person_id=new&con_info=old\';">';
                echo '<i class="icon-plus2"></i> Add New Contact</A></li>';
            }
        }
    }
    echo '</ul>';
    echo '</div>';
    echo '<div class="col-md-12">';

    if (isset($_REQUEST['address_id']) && $_REQUEST['con_info'] != 'old') {
        $h_addr = DBGet(DBQuery(' SELECT sa.ID AS ADDRESS_ID,sa.STREET_ADDRESS_1 as ADDRESS,sa.STREET_ADDRESS_2 as STREET,sa.CITY,sa.STATE,sa.ZIPCODE,sa.BUS_PICKUP,sa.BUS_DROPOFF,sa.BUS_NO from student_address sa WHERE 
                                   sa.TYPE=\'Home Address\' AND sa.COLLEGE_ROLL_NO=\'' . UserStudentID() . '\' AND sa.COLLEGE_ID=\'' . UserCollege() . '\' '));

        $pri_par_id = DBGet(DBQuery('SELECT * FROM students_join_people WHERE COLLEGE_ROLL_NO=' . UserStudentID() . ' AND EMERGENCY_TYPE=\'Primary\''));
        if (count($pri_par_id) > 0) {
            $p_addr = DBGet(DBQuery('SELECT p.STAFF_ID as CONTACT_ID,p.FIRST_NAME,p.MIDDLE_NAME,p.LAST_NAME,p.HOME_PHONE,p.WORK_PHONE,p.CELL_PHONE,p.EMAIL,p.CUSTODY,p.PROFILE_ID,
                                  sa.ID AS ADDRESS_ID,sa.STREET_ADDRESS_1 as ADDRESS,sa.STREET_ADDRESS_2 as STREET,sa.CITY,sa.STATE,sa.ZIPCODE,sa.BUS_PICKUP,sa.BUS_DROPOFF,sa.BUS_NO from people p,student_address sa WHERE p.STAFF_ID=sa.PEOPLE_ID  AND p.STAFF_ID=\'' . $pri_par_id[1]['PERSON_ID'] . '\'  AND sa.PEOPLE_ID IS NOT NULL '));
            $p_addr[1]['RELATIONSHIP'] = $pri_par_id[1]['RELATIONSHIP'];

            $primary_user_profs_ids_arr = array();
            $primary_user_profs_ids = DBGet(DBQuery('SELECT id FROM user_profiles WHERE profile = \'' . 'parent' . '\''));

            foreach ($primary_user_profs_ids as $k => $v) {
                $primary_user_profs_ids_arr[] = $primary_user_profs_ids[$k]['ID'];
            }

            $primary_user_profs_id = implode(',', $primary_user_profs_ids_arr);

            $p_log_addr = DBGet(DBQuery('SELECT USERNAME AS USER_NAME ,PASSWORD FROM login_authentication WHERE USER_ID=\'' . $pri_par_id[1]['PERSON_ID'] . '\' AND PROFILE_ID in (' . $primary_user_profs_id . ')'));
            $p_addr[1]['USER_NAME'] = $p_log_addr[1]['USER_NAME'];
            $p_addr[1]['PASSWORD'] = $p_log_addr[1]['PASSWORD'];
        }
        $m_addr = DBGet(DBQuery(' SELECT sa.ID AS ADDRESS_ID,sa.STREET_ADDRESS_1 as ADDRESS,sa.STREET_ADDRESS_2 as STREET,sa.CITY,sa.STATE,sa.ZIPCODE,sa.BUS_PICKUP,sa.BUS_DROPOFF,sa.BUS_NO from student_address sa WHERE 
                                   sa.TYPE=\'Mail\' AND sa.COLLEGE_ROLL_NO=\'' . UserStudentID() . '\'  AND sa.SYEAR=\'' . UserSyear() . '\' AND sa.COLLEGE_ID=\'' . UserCollege() . '\' '));
        $sec_par_id = DBGet(DBQuery('SELECT * FROM students_join_people WHERE COLLEGE_ROLL_NO=' . UserStudentID() . ' AND EMERGENCY_TYPE=\'Secondary\''));

        if (count($sec_par_id) > 0) {
            $s_addr = DBGet(DBQuery('SELECT p.STAFF_ID as CONTACT_ID,p.FIRST_NAME,p.MIDDLE_NAME,p.LAST_NAME,p.HOME_PHONE,p.WORK_PHONE,p.CELL_PHONE,p.EMAIL,p.CUSTODY,p.PROFILE_ID,
                                  sa.ID AS ADDRESS_ID,sa.STREET_ADDRESS_1 as ADDRESS,sa.STREET_ADDRESS_2 as STREET,sa.CITY,sa.STATE,sa.ZIPCODE,sa.BUS_PICKUP,sa.BUS_DROPOFF,sa.BUS_NO from people p,student_address sa WHERE p.STAFF_ID=sa.PEOPLE_ID  AND p.STAFF_ID=\'' . $sec_par_id[1]['PERSON_ID'] . '\'  AND sa.PEOPLE_ID IS NOT NULL '));


            $s_addr[1]['RELATIONSHIP'] = $sec_par_id[1]['RELATIONSHIP'];

            $s_user_profs_ids_arr = array();
            $s_user_profs_ids = DBGet(DBQuery('SELECT id FROM user_profiles WHERE profile = \'' . 'parent' . '\''));
            foreach ($s_user_profs_ids as $k => $v) {
                $s_user_profs_ids_arr[] = $s_user_profs_ids[$k]['ID'];
            }

            $s_user_profs_id = implode(',', $s_user_profs_ids_arr);

            $p_log_addr = DBGet(DBQuery('SELECT USERNAME AS USER_NAME ,PASSWORD FROM login_authentication WHERE USER_ID=\'' . $sec_par_id[1]['PERSON_ID'] . '\' AND PROFILE_ID in (' . $s_user_profs_id . ')'));
            $s_addr[1]['USER_NAME'] = $p_log_addr[1]['USER_NAME'];
            $s_addr[1]['PASSWORD'] = $p_log_addr[1]['PASSWORD'];
        } else {
            $s_addr = DBGet(DBQuery('SELECT ID AS ADDRESS_ID from student_address WHERE COLLEGE_ROLL_NO=' . UserStudentID() . ' AND TYPE=\'Secondary\' '));
        }
        echo "<INPUT type=hidden name=address_id value=$_REQUEST[address_id]>";

        if ($_REQUEST['address_id'] != '0' && $_REQUEST['address_id'] !== 'old') {


            $profiles_options = DBGet(DBQuery('SELECT PROFILE ,TITLE, ID FROM user_profiles WHERE profile = \'parent\' ORDER BY ID'));
            $i = 1;
            foreach ($profiles_options as $options) {

                $option[$options['ID']] = $options['TITLE'];
                $i++;
            }
            if ($h_addr[1]['ADDRESS_ID'] == 0)
                $size = true;
            else
                $size = false;

            $city_options = _makeAutoSelect('CITY', 'student_address', '', array(array('CITY' => $h_addr[1]['CITY']), array('CITY' => $h_addr[1]['CITY'])), $city_options);
            $state_options = _makeAutoSelect('STATE', 'student_address', '', array(array('STATE' => $h_addr[1]['STATE']), array('STATE' => $h_addr[1]['STATE'])), $state_options);
            $zip_options = _makeAutoSelect('ZIPCODE', 'student_address', '', array(array('ZIPCODE' => $h_addr[1]['ZIPCODE']), array('ZIPCODE' => $h_addr[1]['ZIPCODE'])), $zip_options);



            if ($h_addr[1]['BUS_PICKUP'] == 'N')
                unset($h_addr[1]['BUS_PICKUP']);
            if ($h_addr[1]['BUS_DROPOFF'] == 'N')
                unset($h_addr[1]['BUS_DROPOFF']);
            if ($h_addr[1]['BUS_NO'] == 'N')
                unset($h_addr[1]['BUS_NO']);
            if ($p_addr[1]['CUSTODY'] == 'N')
                unset($p_addr[1]['CUSTODY']);
            if ($s_addr[1]['CUSTODY'] == 'N')
                unset($s_addr[1]['CUSTODY']);

            //hidden fields//
            if ($h_addr[1]['ADDRESS_ID'] != '')
                echo '<input type=hidden name="values[student_address][HOME][ID]" id=pri_person_id value=' . $h_addr[1]['ADDRESS_ID'] . ' />';
            else
                echo '<input type=hidden name="values[student_address][HOME][ID]" id=pri_person_id value=new />';

            if ($m_addr[1]['ADDRESS_ID'] != '')
                echo '<input type=hidden name="values[student_address][MAIL][ID]" value=' . $m_addr[1]['ADDRESS_ID'] . ' />';
            else
                echo '<input type=hidden name="values[student_address][MAIL][ID]" value=new />';

            if ($s_addr[1]['ADDRESS_ID'] != '')
                echo '<input type=hidden name="values[student_address][SECONDARY][ID]" value=' . $s_addr[1]['ADDRESS_ID'] . ' />';
            else
                echo '<input type=hidden name="values[student_address][SECONDARY][ID]" value=new />';


            if ($p_addr[1]['ADDRESS_ID'] != '')
                echo '<input type=hidden name="values[student_address][PRIMARY][ID]" value=' . $p_addr[1]['ADDRESS_ID'] . ' />';
            else
                echo '<input type=hidden name="values[student_address][PRIMARY][ID]" value=new />';

            echo '<br>';


            if ($p_addr[1]['CONTACT_ID'] != '')
                echo '<input type=hidden name="values[people][PRIMARY][ID]" value=' . $p_addr[1]['CONTACT_ID'] . ' />';
            else
                echo '<input type=hidden name="values[people][PRIMARY][ID]" value=new />';

            if ($s_addr[1]['CONTACT_ID'] != '')
                echo '<input type=hidden name="values[people][SECONDARY][ID]" value=' . $s_addr[1]['CONTACT_ID'] . ' />';
            else
                echo '<input type=hidden name="values[people][SECONDARY][ID]" value=new />';


            echo '<FIELDSET><h5 class="text-primary">Student\'s Home Address ';
            if ($h_addr[1]['ADDRESS_ID'] != '0') {
                $display_address = urlencode($h_addr[1]['ADDRESS'] . ', ' . ($h_addr[1]['CITY'] ? ' ' . $h_addr[1]['CITY'] . ', ' : '') . $h_addr[1]['STATE'] . ($h_addr[1]['ZIPCODE'] ? ' ' . $h_addr[1]['ZIPCODE'] : ''));
                $link = 'http://google.com/maps?q=' . $display_address;
                echo '<A class="btn bg-primary btn-xs btn-labeled pull-right" HREF="javascript:void(0);" onclick=\'window.open("' . $link . '","","scrollbars=yes,resizable=yes,width=800,height=700");\'><b><i class="icon-location4"></i></b> Map it</A>';
            }
            echo '</h5>';
            echo '<hr/>';
            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Address Line 1 <span class=text-danger>*</span></label><div class="col-md-8">' . TextInput($h_addr[1]['ADDRESS'], 'values[student_address][HOME][STREET_ADDRESS_1]', '', '') . '</div></div></div>';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Address Line 2</label><div class="col-md-8">' . TextInput($h_addr[1]['STREET'], 'values[student_address][HOME][STREET_ADDRESS_2]', '', '') . '</div></div></div>';
            echo '</div>'; //.row

            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">City <span class=text-danger>*</span></label><div class="col-md-8">' . TextInput($h_addr[1]['CITY'], 'values[student_address][HOME][CITY]', '', '') . '</div></div></div>';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">State <span class=text-danger>*</span></label><div class="col-md-8">' . TextInput($h_addr[1]['STATE'], 'values[student_address][HOME][STATE]', '', '') . '</div></div></div>';
            echo '</div>'; //.row

            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Zip/Postal Code <span class=text-danger>*</span></label><div class="col-md-8">' . TextInput($h_addr[1]['ZIPCODE'], 'values[student_address][HOME][ZIPCODE]', '', '') . '</div></div></div>';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Bus No</label><div class="col-md-8">' . TextInput($h_addr[1]['BUS_NO'], 'values[student_address][HOME][BUS_NO]', '', 'class=cell_small') . '</div></div></div>';
            echo '</div>'; //.row

            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">College Bus Pick-up</label><div class="col-md-8">' . CheckboxInputMod($h_addr[1]['BUS_PICKUP'], 'values[student_address][HOME][BUS_PICKUP]', '', 'CHECKED', $new, '<i class="icon-checkbox-checked"></i>', '<i class="icon-checkbox-unchecked"></i>') . '</div></div></div>';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">College Bus Drop-off</label><div class="col-md-8">' . CheckboxInputMod($h_addr[1]['BUS_DROPOFF'], 'values[student_address][HOME][BUS_DROPOFF]', '', 'CHECKED', $new, '<i class="icon-checkbox-checked"></i>', '<i class="icon-checkbox-unchecked"></i>') . '</div></div></div>';
            echo '</div>'; //.row

            echo '</FIELDSET>';
            echo '<br/>';

            echo '<FIELDSET><h5 class="text-primary">Student\'s Mailing Address</h5>';
            echo '<hr/>';



            if ($m_addr[1]['ADDRESS_ID'] != '' && $h_addr[1]['ADDRESS_ID'] != '') {
                $extra_sql = '';
                if ($m_addr[1]['STREET'] != '')
                    $extra_sql = 'AND STREET_ADDRESS_2=\'' . singleQuoteReplace('', '', $m_addr[1]['STREET']) . '\' ';
                else
                    $extra_sql = 'AND STREET_ADDRESS_2 is NULL ';
                $s_mail_address = DBGet(DBQuery('SELECT COUNT(1) as TOTAL FROM student_address WHERE ID!=\'' . $m_addr[1]['ADDRESS_ID'] . '\' AND STREET_ADDRESS_1=\'' . singleQuoteReplace('', '', $m_addr[1]['ADDRESS']) . '\' AND STREET_ADDRESS_1=\'' . singleQuoteReplace('', '', $p_addr[1]['ADDRESS']) . '\' ' . $extra_sql . 'AND CITY=\'' . singleQuoteReplace('', '', $m_addr[1]['CITY']) . '\' AND STATE=\'' . singleQuoteReplace('', '', $m_addr[1]['STATE']) . '\' AND ZIPCODE=\'' . singleQuoteReplace('', '', $m_addr[1]['ZIPCODE']) . '\' AND TYPE=\'Home Address\' '));
                if ($s_mail_address[1]['TOTAL'] != 0)
                    $m_checked = " CHECKED=CHECKED ";
                else
                    $m_checked = " ";
            }

            echo '<div class="row">';
            if ($h_addr[1]['ADDRESS_ID'] != 0)
                echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">&nbsp;</label><div class="col-md-8"><div id="check_addr"><label class="checkbox-inline"><input class="styled" type="checkbox" ' . $m_checked . ' id="same_addr" name="same_addr" set_check_value value="Y">&nbsp;Same as Home Address &nbsp;</label></div></div></div></div>';
            if ($h_addr[1]['ADDRESS_ID'] == 0)
                echo '<div class="form-group"><div class="col-md-12"><label class="radio-inline"><input type="radio" id="r4" name="r4" value="Y" onClick="hidediv();" checked>&nbsp;Same as Home Address</label><label class="radio-inline"><input type="radio" id="r4" name="r4" value="N" onClick="showdiv();">&nbsp;Add New Address</label></div></div>';
            echo '</div>';

            if ($h_addr[1]['ADDRESS_ID'] == 0)
                echo '<div id="hideShow" style="display:none">';
            else
                echo '<div id="hideShow">';

            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Address Line 1</label><div class="col-md-8">' . TextInput($m_addr[1]['ADDRESS'], 'values[student_address][MAIL][STREET_ADDRESS_1]', '', '') . '</div></div></div>';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Address Line 2</label><div class="col-md-8">' . TextInput($m_addr[1]['STREET'], 'values[student_address][MAIL][STREET_ADDRESS_2]', '', '') . '</div></div></div>';
            echo '</div>';

            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">City</label><div class="col-md-8">' . TextInput($m_addr[1]['CITY'], 'values[student_address][MAIL][CITY]', '', '') . '</div></div></div>';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">State</label><div class="col-md-8">' . TextInput($m_addr[1]['STATE'], 'values[student_address][MAIL][STATE]', '', '') . '</div></div></div>';
            echo '</div>';

            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Zip/Postal Code</label><div class="col-md-8">' . TextInput($m_addr[1]['ZIPCODE'], 'values[student_address][MAIL][ZIPCODE]', '', '') . '</div></div></div>';
            echo '</div>';

            echo '</FIELDSET>';

            echo '<br/>';

            echo '<FIELDSET><h5 class="text-primary">Primary Emergency Contact</h5>';
            echo '<hr/>';
            if (count($qr_ot_stu_asso) > 1)
                echo "<TR><td> <A HREF=Modules.php?modname=$_REQUEST[modname]&person_id=" . $p_addr[1][CONTACT_ID] . "&modfunc=clearall&relation=primary>Remove Parent</A></TD></tr>";

            $prim_relation_options = _makeAutoSelect('RELATIONSHIP', 'students_join_people', 'PRIMARY', $p_addr['RELATIONSHIP'], $relation_options);

            if (User('PROFILE') != 'teacher') {
                echo '<div class="row">';
                if (User('PROFILE') == 'student' || User('PROFILE') == 'parent') {
                    echo '<div class="col-md-8"><div class="form-group"><label class="control-label text-right col-md-3">Relationship to Student<span class=text-danger>*</span></label><div class="col-md-9">' . _makeAutoSelectInputX($p_addr[1]['RELATIONSHIP'], 'RELATIONSHIP', 'people', 'PRIMARY', '', $prim_relation_options) . '</div></div></div>';
                } else {
                    // echo '<div class="col-md-8"><div class="form-group"><label class="control-label text-right col-md-3">Relationship to Student<span class=text-danger>*</span></label><div class="col-md-9"><div class="input-group">' . _makeAutoSelectInputX($p_addr[1]['RELATIONSHIP'], 'RELATIONSHIP', 'people', 'PRIMARY', '', $prim_relation_options) . '<span class="input-group-btn"><input type="button" name="lookup" class="btn btn-primary" value="Lookup" onclick="javascript:window.open(\'ForWindow.php?modname=' . $_REQUEST['modname'] . '&modfunc=lookup&type=primary&ajax=' . $_REQUEST['ajax'] . '&address_id=' . $_REQUEST['address_id'] . '\',\'blank\',\'resizable=yes,scrollbars=yes,width=600,height=600\');return false;"></span></div></div></div></div>';
                    // echo '<div class="col-md-8"><div class="form-group"><label class="control-label text-right col-md-3">Relationship to Student<span class=text-danger>*</span></label><div class="col-md-9"><div class="input-group">' . _makeAutoSelectInputX($p_addr[1]['RELATIONSHIP'], 'RELATIONSHIP', 'people', 'PRIMARY', '', $prim_relation_options) . '<span class="input-group-btn"><input type=button  data-toggle="modal" data-target="#modal_default_lookup" name=lookup class=btn btn-primary value=Lookup onclick=(\'modal_default_lookup\');></span></div></div></div></div>';
//                    javascript:void(0) data-toggle='modal' data-target='#modal_default'
                    echo '<div class="col-md-8"><div class="form-group"><label class="control-label text-right col-md-3">Relationship to Student<span class=text-danger>*</span></label><div class="col-md-9"><div class="input-group">' . _makeAutoSelectInputX($p_addr[1]['RELATIONSHIP'], 'RELATIONSHIP', 'people', 'PRIMARY', '', $prim_relation_options) . '<span class="input-group-btn"><input type=button  data-toggle="modal"  name=lookup class=btn btn-primary value=Lookup onclick=modal_parenttype(\'primary\');></span></div></div></div></div>';
                }
                echo '</div>';
            }

            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">First Name<span class=text-danger>*</span></label><div class="col-md-8">' . TextInput($p_addr[1]['FIRST_NAME'], 'values[people][PRIMARY][FIRST_NAME]', '', 'id=pri_fname') . '</div></div></div>';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Last Name<span class=text-danger>*</span></label><div class="col-md-8">' . TextInput($p_addr[1]['LAST_NAME'], 'values[people][PRIMARY][LAST_NAME]', '', 'id=pri_lname') . '</div></div></div>';
            echo '</div>'; //.row

            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Home Phone</label><div class="col-md-8">' . TextInput($p_addr[1]['HOME_PHONE'], 'values[people][PRIMARY][HOME_PHONE]', '', 'id=pri_hphone') . '</div></div></div>';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Work Phone</label><div class="col-md-8">' . TextInput($p_addr[1]['WORK_PHONE'], 'values[people][PRIMARY][WORK_PHONE]', '', 'id=pri_wphone') . '</div></div></div>';
            echo '</div>'; //.row

            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Cell/Mobile Phone</label><div class="col-md-8">' . TextInput($p_addr[1]['CELL_PHONE'], 'values[people][PRIMARY][CELL_PHONE]', '', 'id=pri_cphone') . '</div></div></div>';
            echo'<input type=hidden id=hidden_primary name=hidden_primary>';
            if ($p_addr[1]['CONTACT_ID'] == '') {
                echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Emaill</label><div class="col-md-8">' . TextInput($p_addr[1]['EMAIL'], 'values[people][PRIMARY][EMAIL]', '', 'autocomplete=off id=pri_email onkeyup=peoplecheck_email(this,1,0) ') . '<p id="email_1" class="help-block"></p></div></div></div>';
            } else {
                echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Email</label><div class="col-md-8">' . TextInput($p_addr[1]['EMAIL'], 'values[people][PRIMARY][EMAIL]', '', 'autocomplete=off id=pri_email onkeyup=peoplecheck_email(this,1,' . $p_addr[1]['CONTACT_ID'] . ') ') . '<p class="help-block" id="email_1"></p></div></div></div>';
            }
            echo '</div>'; //.row

            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Custody of Student</label><div class="col-md-8">' . CheckboxInputMod($p_addr[1]['CUSTODY'], 'values[people][PRIMARY][CUSTODY]', '', 'CHECKED', $new, '<i class="icon-checkbox-checked"></i>', '<i class="icon-checkbox-unchecked"></i>') . '</div></div></div>';
            echo '</div>'; //.row

            if ($p_addr[1]['USER_NAME'] == '') {
                $portal_check = '';
                $style = 'style="display:none"';
            } else {
                $portal_check = 'checked="checked"';
                $style = '';
            }
            if (User('PROFILE_ID') == 3 || User('PROFILE') == 'teacher')
                $student_disable_all = 'disabled';
            echo '<input type=hidden name=prim_custody value="' . $p_addr[1]['CUSTODY'] . '" />';
            echo '<input type="hidden" id=pri_val_pass value="Y">';
            echo '<input type="hidden" name=selected_pri_parent id=selected_pri_parent value="">';
            echo '<input type="hidden" id=pri_val_user value="Y">';
            echo '<input type="hidden" id=val_email_1 name=val_email_1 value="Y">';


            echo '<div class="row">';
            if ($portal_check == '')
                echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Portal User</label><div class="col-md-8"><label class="form-control"><input type="checkbox" width="25" name="primary_portal" value="Y" id="portal_1" onClick="portal_toggle(1);" ' . $portal_check . '/></label></div></div></div>';
            else
                echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Portal User</label><div class="col-md-8"><div id="checked_1" class="form-control" disabled><i class="icon-checkbox-checked"></i></div></div></div></div>';
            echo '</div>'; //.row

            echo '<div id="portal_div_1" ' . $style . ' class="well">';
            echo '<div class="row">';
            if ($p_addr[1]['USER_NAME'] == '' && $p_addr[1]['PASSWORD'] == '') {
                echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Username</label><div class="col-md-8">' . TextInput($p_addr[1]['USER_NAME'], 'values[people][PRIMARY][USER_NAME]', '', 'id=primary_username onblur="usercheck_init_mod(this,1)" ') . '<div id="ajax_output_1"></div></div></div></div>';
                echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Password</label><div class="col-md-8">' . TextInput($p_addr[1]['PASSWORD'], 'values[people][PRIMARY][PASSWORD]', '', 'id=primary_password onkeyup="passwordStrengthMod(this.value,1);" onblur="validate_password_mod(this.value,1);"') . '<p class="help-block" id="passwordStrength1"></p></div></div></div>';
            } else {
                echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Username</label><div class="col-md-8"><div id="uname1" class="form-control" disabled>' . $p_addr[1]['USER_NAME'] . '</div></div></div></div>';
                echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Password</label><div class="col-md-8"><div id="pwd1" class="form-control" disabled>' . str_repeat('*', strlen($p_addr[1]['PASSWORD'])) . '</div></div></div></div>';
            }
            echo '</div>'; //.row

            $user_profs = DBGet(DBQuery('SELECT * FROM user_profiles WHERE profile = \'' . 'parent' . '\''));

            foreach ($user_profs as $user_profs_value) {
                $user_prof_options[$user_profs_value['ID']] = $user_profs_value['TITLE'];
            }
            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">User Profile</label><div class="col-md-8">' . SelectInput($p_addr[1]['PROFILE_ID'], 'values[people][PRIMARY][PROFILE_ID]', '', $user_prof_options, FALSE, ' id=pri_prof_id') . '</div></div></div>';
            echo '</div>'; //.row
            echo '</div>'; //#portal_div_1

            echo '<div id="portal_hidden_div_1" ></div>';

            echo '<div class="row">';
            if ($h_addr[1]['ADDRESS_ID'] == 0) {
                echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4"></label><div class="col-md-8"><label class="radio-inline"><input type="radio" id="rps" name="r5" value="Y" onClick="prim_hidediv();" checked>&nbsp;Same as Student\'s Home Address</label><label class="radio-inline"><input type="radio" id="rpn" name="r5" value="N" onClick="prim_showdiv();">&nbsp;Add New Address</label></div></div></div>';
            }
            echo '</div>'; //.row

            if ($h_addr[1]['ADDRESS_ID'] == 0)
                echo '<div id="prim_hideShow" style="display:none">';
            else
                echo '<div id="prim_hideShow">';
            echo '<hr/>';


            echo '<div class="row">';
            if ($h_addr[1]['ADDRESS_ID'] != '' && $p_addr[1]['ADDRESS_ID'] != '') {
                $extra_sql = '';
                if ($p_addr[1]['STREET'] != '')
                    $extra_sql = 'AND STREET_ADDRESS_2=\'' . singleQuoteReplace('', '', $m_addr[1]['STREET']) . '\' ';
                else
                    $extra_sql = 'AND STREET_ADDRESS_2 is NULL ';

                $s_prim_address = DBGet(DBQuery('SELECT COUNT(1) as TOTAL FROM student_address WHERE ID!=\'' . $p_addr[1]['ADDRESS_ID'] . '\'' . $extra_sql . 'AND CITY=\'' . singleQuoteReplace('', '', $p_addr[1]['CITY']) . '\' AND STATE=\'' . singleQuoteReplace('', '', $p_addr[1]['STATE']) . '\' AND ZIPCODE=\'' . singleQuoteReplace('', '', $p_addr[1]['ZIPCODE']) . '\' AND TYPE=\'Home Address\' '));


                if ($s_prim_address[1]['TOTAL'] != 0)
                    $p_checked = " CHECKED=CHECKED ";
                else
                    $p_checked = " ";
                if ($p_addr[1]['ADDRESS_ID'] != 0)
                    echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">&nbsp;</label><div class="col-md-8"><div id="check_addr"><label class="checkbox-inline"><input class="styled" type="checkbox" ' . $p_checked . ' id="prim_addr" name="prim_addr" value="Y">Same as Home Address</label></div></div></div></div>';
            }
            echo '</div>'; //.row

            echo '<div class="row">';
            echo '<div class="col-md-12"><div class="form-group"><label class="control-label text-right col-md-2">Address Line 1</label><div class="col-md-10"><div class="input-group">' . TextInput($p_addr[1]['ADDRESS'], 'values[student_address][PRIMARY][STREET_ADDRESS_1]', '', 'id=pri_address');
            echo '<span class="input-group-btn">';
            if ($p_addr[1]['ADDRESS_ID'] != 0) {
                $display_address = urlencode($p_addr[1]['ADDRESS'] . ', ' . ($p_addr[1]['CITY'] ? ' ' . $p_addr[1]['CITY'] . ', ' : '') . $p_addr[1]['STATE'] . ($p_addr[1]['ZIPCODE'] ? ' ' . $p_addr[1]['ZIPCODE'] : ''));
                $link = 'http://google.com/maps?q=' . $display_address;
                echo '<A class="btn bg-primary btn-xs btn-labeled" HREF="javascript:void(0);" onclick=\'window.open("' . $link . '","","scrollbars=yes,resizable=yes,width=800,height=700");\'><b><i class="icon-location4"></i></b> Map it</A>';
            }
            echo '</span></div>';
            echo '</div></div></div>';
            echo '</div>'; //.row

            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Address Line 2</label><div class="col-md-8">' . TextInput($p_addr[1]['STREET'], 'values[student_address][PRIMARY][STREET_ADDRESS_2]', '', 'id=pri_street') . '</div></div></div>';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">City</label><div class="col-md-8">' . TextInput($p_addr[1]['CITY'], 'values[student_address][PRIMARY][CITY]', '', 'id=pri_city') . '</div></div></div>';
            echo '</div>'; //.row

            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">State</label><div class="col-md-8">' . TextInput($p_addr[1]['STATE'], 'values[student_address][PRIMARY][STATE]', '', 'id=pri_state') . '</div></div></div>';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Zip/Postal Code</label><div class="col-md-8">' . TextInput($p_addr[1]['ZIPCODE'], 'values[student_address][PRIMARY][ZIPCODE]', '', 'id=pri_zip') . '</div></div></div>';
            echo '</div>'; //.row
            echo '</div>'; //#prim_hideShow

            echo '</FIELDSET>';


            ############################################################################################

            echo '<FIELDSET><h5 class="text-primary">Secondary Emergency Contact</h5>';
            echo '<hr/>';

            $sec_relation_options = _makeAutoSelect('RELATIONSHIP', 'students_join_people', 'SECONDARY', $s_addr[1]['RELATIONSHIP'], $relation_options);
            if (User('PROFILE') != 'teacher') {
                echo '<div class="row">';
                if (User('PROFILE') == 'student' || User('PROFILE') == 'parent') {
                    echo '<div class="col-md-8"><div class="form-group"><label class="control-label text-right col-md-3">Relationship to Student</label><div class="col-md-9">' . _makeAutoSelectInputX($s_addr[1]['RELATIONSHIP'], 'RELATIONSHIP', 'people', 'SECONDARY', '', $sec_relation_options) . '</div></div></div>';
                } else {
                    //echo '<div class="col-md-8"><div class="form-group"><label class="control-label text-right col-md-3">Relationship to Student</label><div class="col-md-9"><div class="input-group">' . _makeAutoSelectInputX($s_addr[1]['RELATIONSHIP'], 'RELATIONSHIP', 'people', 'SECONDARY', '', $sec_relation_options) . '<span class="input-group-btn"><input type="button" class="btn btn-primary" name="lookup" value="Lookup" onclick="javascript:window.open(\'ForWindow.php?modname=' . $_REQUEST['modname'] . '&modfunc=lookup&type=secondary&ajax=' . $_REQUEST['ajax'] . '&address_id=' . $_REQUEST['address_id'] . '\',\'blank\',\'resizable=yes,scrollbars=yes,width=600,height=600\');return false;"></span></div></div></div></div>';
//                echo '<div class="col-md-8"><div class="form-group"><label class="control-label text-right col-md-3">Relationship to Student<span class=text-danger>*</span></label><div class="col-md-9"><div class="input-group">' . _makeAutoSelectInputX($s_addr[1]['RELATIONSHIP'], 'RELATIONSHIP', 'people', 'SECONDARY', '', $sec_relation_options) . '<span class="input-group-btn"><input type=button  data-toggle="modal" data-target="#modal_default_lookup" name=lookup class=btn btn-primary value=Lookup onclick=(\'modal_default_lookup\');></span></div></div></div></div>';
//                
                    echo '<div class="col-md-8"><div class="form-group"><label class="control-label text-right col-md-3">Relationship to Student</label><div class="col-md-9"><div class="input-group">' . _makeAutoSelectInputX($s_addr[1]['RELATIONSHIP'], 'RELATIONSHIP', 'people', 'SECONDARY', '', $sec_relation_options) . '<span class="input-group-btn"><input type=button  data-toggle="modal"  name=lookup class=btn btn-primary value=Lookup onclick=modal_parenttype(\'secondary\');></span></div></div></div></div>';
                }
                echo '</div>'; //.row
            }

            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">First Name</label><div class="col-md-8">' . TextInput($s_addr[1]['FIRST_NAME'], 'values[people][SECONDARY][FIRST_NAME]', '', 'id=sec_fname') . '</div></div></div>';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Last Name</label><div class="col-md-8">' . TextInput($s_addr[1]['LAST_NAME'], 'values[people][SECONDARY][LAST_NAME]', '', 'id=sec_lname ') . '</div></div></div>';
            echo '</div>'; //.row

            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Home Phone</label><div class="col-md-8">' . TextInput($s_addr[1]['HOME_PHONE'], 'values[people][SECONDARY][HOME_PHONE]', '', 'id=sec_hphone ') . '</div></div></div>';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Work Phone</label><div class="col-md-8">' . TextInput($s_addr[1]['WORK_PHONE'], 'values[people][SECONDARY][WORK_PHONE]', '', 'id=sec_wphone') . '</div></div></div>';
            echo '</div>'; //.row

            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Cell/Mobile Phone</label><div class="col-md-8">' . TextInput($s_addr[1]['CELL_PHONE'], 'values[people][SECONDARY][CELL_PHONE]', '', 'id=sec_cphone') . '</div></div></div>';
            echo'<input type=hidden id=hidden_secondary name=hidden_secondary>';
            if ($s_addr[1]['CONTACT_ID'] == '') {
                echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Email</label><div class="col-md-8">' . TextInput($s_addr[1]['EMAIL'], 'values[people][SECONDARY][EMAIL]', '', 'autocomplete=off id=sec_email onkeyup=peoplecheck_email(this,2,0) ') . '<p id="email_2"></p></div></div></div>';
            } else {
                echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Email</label><div class="col-md-8">' . TextInput($s_addr[1]['EMAIL'], 'values[people][SECONDARY][EMAIL]', '', 'autocomplete=off id=sec_email onkeyup=peoplecheck_email(this,2,' . $s_addr[1]['CONTACT_ID'] . ') ') . '<p id="email_2"></p></div></div></div>';
            }
            echo '</div>'; //.row


            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Custody of Student</label><div class="col-md-8">' . CheckboxInputMod($s_addr[1]['CUSTODY'], 'values[people][SECONDARY][CUSTODY]', '', 'CHECKED', $new, '<i class="icon-checkbox-checked"></i>', '<i class="icon-checkbox-unchecked"></i>') . '</div></div></div>';
            echo '</div>'; //.row

            if ($s_addr[1]['USER_NAME'] == '') {
                $portal_check = '';
                $style = 'style="display:none"';
            } else {
                $portal_check = 'checked="checked"';
                $style = '';
            }

            echo '<input type="hidden" id=sec_val_pass value="Y">';
            echo '<input type="hidden" id=sec_val_user value="Y">';
            echo '<input type="hidden" name=selected_sec_parent id=selected_sec_parent value="">';
            echo '<input type="hidden" id=val_email_2 name=val_email_2 value="Y">';

            echo '<div class="row">';
            if ($portal_check == '') {
                echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Portal User</label><div class="col-md-8"><label class="form-control"><input type="checkbox" name="secondary_portal" value="Y" id="portal_2" onClick="portal_toggle(2);" ' . $portal_check . '/></label></div></div></div>';
            } else {
                echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Portal User</label><div class="col-md-8"><div id=checked_2><i class="icon-checkbox-checked"></i></div></div></div></div>';
            }
            echo '</div>'; //.row

            echo '<div id="portal_div_2" ' . $style . ' class="well">';

            echo '<div class="row">';
            if ($s_addr[1]['USER_NAME'] == '' && $s_addr[1]['PASSWORD'] == '') {
                echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Username</label><div class="col-md-8">' . TextInput($s_addr[1]['USER_NAME'], 'values[people][SECONDARY][USER_NAME]', '', 'id=secondary_username onkeyup="usercheck_init_mod(this,2)" ') . '<p class="help-block" id="ajax_output_2"></p></div></div></div>';
                echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Password</label><div class="col-md-8">' . TextInput($s_addr[1]['PASSWORD'], 'values[people][SECONDARY][PASSWORD]', '', 'id=secondary_password onkeyup="passwordStrengthMod(this.value,2);validate_password_mod(this.value,2);"') . '<p class="help-block" id="passwordStrength2"></p></div></div></div>';
            } else {
                echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Username</label><div class="col-md-8"><div id=uname2>' . $s_addr[1]['USER_NAME'] . '</div></div></div></div>';
                echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Password</label><div class="col-md-8"><div id=pwd2>' . str_repeat('*', strlen($s_addr[1]['PASSWORD'])) . '</div></div></div></div>';
            }
            echo '</div>'; //.row

            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">User Profile</label><div class="col-md-8">' . SelectInput($s_addr[1]['PROFILE_ID'], 'values[people][SECONDARY][PROFILE_ID]', '', $user_prof_options, FALSE, ' id=sec_prof_id') . '</div></div></div>';
            echo '</div>'; //.row

            echo '</div>'; //#portal_div_2

            echo '<div id="portal_hidden_div_2" ></div>';

            if ($h_addr[1]['ADDRESS_ID'] == 0) {
                echo '<div class="row">';
                echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4"></label><div class="col-md-8"><label class="radio-inline"><input type="radio" id="rss" name="r6" value="Y" onClick="sec_hidediv();">&nbsp;Same as Student\'s Home Address</label><label class="radio-inline"><input type="radio" id="rsn" name="r6" value="N" onClick="sec_showdiv();">&nbsp;Add New Address</label></div></div></div>';
                echo '</div>'; //.row                
            }

            if ($h_addr[1]['ADDRESS_ID'] == 0) {
                echo '<div id="sec_hideShow" style="display:none">';
            } else {
                echo '<div id="sec_hideShow">';
            }

            echo '<hr/>';

            $s_sec_address = DBGet(DBQuery('SELECT COUNT(1) as TOTAL FROM student_address WHERE ID!=\'' . $s_addr[1]['ADDRESS_ID'] . '\' AND STREET_ADDRESS_1=\'' . singleQuoteReplace('', '', $s_addr[1]['ADDRESS']) . '\' AND STREET_ADDRESS_1=\'' . singleQuoteReplace('', '', $p_addr[1]['ADDRESS']) . '\'    ' . ($s_addr[1]['STREET'] != '' ? 'AND STREET_ADDRESS_2=\'' . singleQuoteReplace('', '', $s_addr[1]['STREET']) . '\'' : ' ') . '  AND CITY=\'' . singleQuoteReplace('', '', $s_addr[1]['CITY']) . '\' AND STATE=\'' . singleQuoteReplace('', '', $s_addr[1]['STATE']) . '\' AND ZIPCODE=\'' . $s_addr[1]['ZIPCODE'] . '\' AND TYPE=\'Home Address\' AND COLLEGE_ROLL_NO=' . UserStudentID()));
            if ($s_sec_address[1]['TOTAL'] != 0)
                $s_checked = " CHECKED=CHECKED ";
            else
                $s_checked = " ";
            if ($h_addr[1]['ADDRESS_ID'] != 0) {
                echo '<div class="row">';
                echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">&nbsp;</label><div class="col-md-8"><div id="check_addr"><label class="checkbox-inline"><input class="styled" type="checkbox" ' . $s_checked . ' id="sec_addr" name="sec_addr" value="Y">Same as Home Address</label></div></div></div></div>';
                echo '</div>'; //.row 
            }

            echo '<div class="row">';
            echo '<div class="col-md-12"><div class="form-group"><label class="control-label text-right col-md-2">Address Line 1</label><div class="col-md-10"><div class="input-group">' . TextInput($s_addr[1]['ADDRESS'], 'values[student_address][SECONDARY][STREET_ADDRESS_1]', '', 'id=sec_address');
            if ($h_addr[1]['ADDRESS_ID'] != 0) {
                $display_address = urlencode($s_addr[1]['ADDRESS'] . ', ' . ($s_addr[1]['CITY'] ? ' ' . $s_addr[1]['CITY'] . ', ' : '') . $s_addr[1]['STATE'] . ($s_addr[1]['ZIPCODE'] ? ' ' . $s_addr[1]['ZIPCODE'] : ''));
                $link = 'http://google.com/maps?q=' . $display_address;
                echo '<span class="input-group-btn">';
                echo '<a class="btn bg-primary btn-xs btn-labeled" HREF="javascript:void(0);" onclick=\'window.open("' . $link . '","","scrollbars=yes,resizable=yes,width=800,height=700");\'><b><i class="icon-location4"></i></b> Map it</a>';
                echo '</span>';
            }
            echo '</div>'; //.input-group
            echo '</div></div></div>';
            echo '</div>'; //.row

            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Address Line 2</label><div class="col-md-8">' . TextInput($s_addr[1]['STREET'], 'values[student_address][SECONDARY][STREET_ADDRESS_2]', '', 'id=sec_street') . '</div></div></div>';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">City</label><div class="col-md-8">' . TextInput($s_addr[1]['CITY'], 'values[student_address][SECONDARY][CITY]', '', 'id=sec_city') . '</div></div></div>';
            echo '</div>'; //.row

            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">State</label><div class="col-md-8">' . TextInput($s_addr[1]['STATE'], 'values[student_address][SECONDARY][STATE]', '', 'id=sec_state') . '</div></div></div>';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Zip/Postal Code</label><div class="col-md-8">' . TextInput($s_addr[1]['ZIPCODE'], 'values[student_address][SECONDARY][ZIPCODE]', '', 'id=sec_zip') . '</div></div></div>';
            echo '</div>'; //.row
            echo '</div>';


            echo'</TD></TR>';
            echo '</TABLE>';  // close 3d
            //
############################################################################################			
        }
    } else
        echo '';


    $separator = '<HR>';
}

$parent_user_profs = DBGet(DBQuery('SELECT * FROM user_profiles WHERE profile = \'' . 'parent' . '\''));

foreach ($parent_user_profs as $parent_user_profs_value) {
    $parent_user_prof_options[$parent_user_profs_value['ID']] = $parent_user_profs_value['TITLE'];
}

if ($_REQUEST['person_id'] && $_REQUEST['con_info'] == 'old') {
    echo "<INPUT type=hidden name=person_id value=$_REQUEST[person_id]>";

    if ($_REQUEST['person_id'] != 'old') {
        if ($_REQUEST['person_id'] != 'new') {
            $other_par_id = DBGet(DBQuery('SELECT * FROM students_join_people WHERE COLLEGE_ROLL_NO=' . UserStudentID() . ' AND PERSON_ID=' . $_REQUEST['person_id'] . ' AND EMERGENCY_TYPE=\'Other\''));

            $o_addr = DBGet(DBQuery('SELECT p.STAFF_ID as PERSON_ID,p.FIRST_NAME,p.MIDDLE_NAME,p.LAST_NAME,p.HOME_PHONE,p.WORK_PHONE,p.CELL_PHONE,p.EMAIL,p.CUSTODY,p.PROFILE_ID,
                                                  sa.ID AS ADDRESS_ID,sa.STREET_ADDRESS_1 as ADDRESS,sa.STREET_ADDRESS_2 as STREET,sa.CITY,sa.STATE,sa.ZIPCODE,sa.BUS_PICKUP,sa.BUS_DROPOFF,sa.BUS_NO from people p,student_address sa WHERE p.STAFF_ID=sa.PEOPLE_ID  AND p.STAFF_ID=\'' . $_REQUEST['person_id'] . '\'  AND sa.PEOPLE_ID IS NOT NULL '));
            $o_addr[1]['RELATIONSHIP'] = $other_par_id[1]['RELATIONSHIP'];
            $o_addr[1]['IS_EMERGENCY'] = $other_par_id[1]['IS_EMERGENCY'];

            $parent_user_profs_ids_arr = array();
            $parent_user_profs_ids = DBGet(DBQuery('SELECT id FROM user_profiles WHERE profile = \'' . 'parent' . '\''));

            foreach ($parent_user_profs_ids as $k => $v) {
                $parent_user_profs_ids_arr[] = $parent_user_profs_ids[$k]['ID'];
            }

            $parent_user_profs_id = implode(',', $parent_user_profs_ids_arr);

            $p_log_addr = DBGet(DBQuery('SELECT USERNAME AS USER_NAME ,PASSWORD FROM login_authentication WHERE USER_ID=\'' . $_REQUEST['person_id'] . '\' AND PROFILE_ID in (' . $parent_user_profs_id . ')'));
            $o_addr[1]['USER_NAME'] = $p_log_addr[1]['USER_NAME'];
            $o_addr[1]['PASSWORD'] = $p_log_addr[1]['PASSWORD'];
        }

        if ($o_addr[1]['PERSON_ID'] != '')
            echo '<input type=hidden name="values[people][OTHER][ID]" id=oth_person_id value=' . $o_addr[1]['PERSON_ID'] . ' />';
        else
            echo '<input type=hidden name="values[people][OTHER][ID]" id=oth_person_id value=new />';

        if ($o_addr[1]['ADDRESS_ID'] != '')
            echo '<input type=hidden name="values[student_address][OTHER][ID]" value=' . $o_addr[1]['ADDRESS_ID'] . ' />';
        else
            echo '<input type=hidden name="values[student_address][OTHER][ID]" value=new />';

        $relation_options = _makeAutoSelect('RELATIONSHIP', 'students_join_people', 'OTHER', $o_addr[1]['RELATIONSHIP'], $relation_options);

        if ($o_addr[1]['IS_EMERGENCY'] == 'N')
            unset($o_addr[1]['IS_EMERGENCY']);
        if ($o_addr[1]['CUSTODY'] == 'N')
            unset($o_addr[1]['CUSTODY']);
        if ($o_addr[1]['BUS_PICKUP'] == 'N')
            unset($o_addr[1]['BUS_PICKUP']);
        if ($o_addr[1]['BUS_DROPOFF'] == 'N')
            unset($o_addr[1]['BUS_DROPOFF']);
        if ($o_addr[1]['BUS_NO'] == 'N')
            unset($o_addr[1]['BUS_NO']);

        echo '<FIELDSET><h5 class="text-primary">Additional Contact</h5>'; // open 3e
        $qr_ot_stu_asso = DBGet(DBQuery('select * from students_join_people where person_id=\'' . $s_addr[1][CONTACT_ID] . '\''));
        if (count($qr_ot_stu_asso) > 1)
            echo "<A HREF=Modules.php?modname=$_REQUEST[modname]&person_id=" . $o_addr[1][CONTACT_ID] . "&modfunc=clearall&relation=Other >Remove Parent</A>";

        echo '<div class="panel panel-default">';
        if ($_REQUEST['person_id'] != 'new' && $_REQUEST['con_info'] == 'old') {
            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-5">This is an Emergency Contact</label><div class="col-md-1"><input type=hidden name=values[people][OTHER][IS_EMERGENCY_HIDDEN] id=IS_EMERGENCY_HIDDEN value="N">' . CheckboxInputMod($o_addr[1]['IS_EMERGENCY'], 'values[people][OTHER][IS_EMERGENCY]', '', 'CHECKED', $new, '<i class="icon-checkbox-checked"></i>', '<i class="icon-checkbox-unchecked"></i>') . '</div></div></div>';
            echo '</div>'; //.row

            echo '<hr/>';

//            echo '<div class="row">';
//            echo '<div class="col-md-8"><div class="form-group"><label class="control-label text-right col-md-3">Relationship to Student</label><div class="col-md-9"><div class="input-group">' . _makeAutoSelectInputX($o_addr[1]['RELATIONSHIP'], 'RELATIONSHIP', 'people', 'OTHER', '', $relation_options) . '<span class="input-group-btn"><input type="button" class="btn btn-primary" name="lookup" value="Lookup" onclick="javascript:window.open(\'ForWindow.php?modname=' . $_REQUEST['modname'] . '&modfunc=lookup&type=other&ajax=' . $_REQUEST['ajax'] . '&add_id=' . $o_addr[1]['PERSON_ID'] . '&address_id=' . $_REQUEST['address_id'] . '\',\'blank\',\'resizable=yes,scrollbars=yes,width=600,height=600\');return false;"></span></div></div></div></div>';
//            echo '</div>'; //.row
            echo '<div class="col-md-8"><div class="form-group"><label class="control-label text-right col-md-3">Relationship to Student<span class=text-danger>*</span></label><div class="col-md-9"><div class="input-group">' . _makeAutoSelectInputX($o_addr[1]['RELATIONSHIP'], 'RELATIONSHIP', 'people', 'OTHER', '', $sec_relation_options) . '<span class="input-group-btn"><input type=button  data-toggle="modal"  name=lookup class=btn btn-primary value=Lookup onclick=modal_parenttype(\'other\',\'' . $o_addr[1][PERSON_ID] . '\');></span></div></div></div></div>';
            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">First Name<span class=text-danger>*</span></label><div class="col-md-8"><DIV id=person_f_' . $o_addr[1]['PERSON_ID'] . '><div class="form-control" onclick=\'addHTML("' . str_replace('"', '\"', _makePeopleInput($o_addr[1]['FIRST_NAME'], 'people', 'FIRST_NAME', 'OTHER', '', '')) . '","person_f_' . $o_addr[1]['PERSON_ID'] . '",true);\'>' . $o_addr[1]['FIRST_NAME'] . '</div></DIV></div></div></div>';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Last Name<span class=text-danger>*</span></label><div class="col-md-8"><DIV id=person_l_' . $o_addr[1]['PERSON_ID'] . '><div class="form-control" onclick=\'addHTML("' . str_replace('"', '\"', _makePeopleInput($o_addr[1]['LAST_NAME'], 'people', 'LAST_NAME', 'OTHER', '', '')) . '","person_l_' . $o_addr[1]['PERSON_ID'] . '",true);\'>' . $o_addr[1]['LAST_NAME'] . '</div></DIV></div></div></div>';
            echo '</div>'; //.row

            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Home Phone</label><div class="col-md-8">' . TextInput($o_addr[1]['HOME_PHONE'], 'values[people][OTHER][HOME_PHONE]', '', '') . '</div></div></div>';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Work Phone</label><div class="col-md-8">' . TextInput($o_addr[1]['WORK_PHONE'], 'values[people][OTHER][WORK_PHONE]', '', '') . '</div></div></div>';
            echo '</div>'; //.row
            echo'<input type=hidden id=hidden_other name=hidden_other>';
            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Mobile Phone</label><div class="col-md-8">' . TextInput($o_addr[1]['CELL_PHONE'], 'values[people][OTHER][CELL_PHONE]', '', '') . '</div></div></div>';
            if ($o_addr[1]['PERSON_ID'] == '') {
                echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Email<span class=text-danger>*</span></label><div class="col-md-8">' . TextInput($o_addr[1]['EMAIL'], 'values[people][OTHER][EMAIL]', '', 'autocomplete=off onkeyup=peoplecheck_email(this,2,0) ') . '<p id="email_2" class="help-block"></p></div></div></div>';
            } else {
                echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Email<span class=text-danger>*</span></label><div class="col-md-8">' . TextInput($o_addr[1]['EMAIL'], 'values[people][OTHER][EMAIL]', '', 'autocomplete=off onkeyup=peoplecheck_email(this,2,' . $o_addr[1]['PERSON_ID'] . ') ') . '<p id="email_2" class="help-block"></p></div></div></div>';
            }
            echo '</div>'; //.row

            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Custody</label><div class="col-md-8">' . CheckboxInputMod($o_addr[1]['CUSTODY'], 'values[people][OTHER][CUSTODY]', '', 'CHECKED', $new, '<i class="icon-checkbox-checked"></i>', '<i class="icon-checkbox-unchecked"></i>') . '</div></div></div>';
            if ($o_addr[1]['USER_NAME'] == '') {
                $portal_check = '';
                $style = 'style="display:none"';
            } else {
                $portal_check = 'checked="checked"';
                $style = '';
            }
            echo '<input type="hidden" id=oth_val_pass value="Y">';
            echo '<input type="hidden" id=oth_val_user value="Y">';
            echo '<input type="hidden" name=selected_oth_parent id=selected_oth_parent value="">';
            echo '<input type="hidden" id=val_email_2 name=val_email_2 value="Y">';
            echo '</div>'; //.row

            echo '<div class="row">';
            if ($portal_check == '') {
                echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Portal User</label><div class="col-md-8"><label class="form-control"><input type="checkbox" name="other_portal" value="Y" id="portal_2" onClick="portal_toggle(2);" ' . $portal_check . '/></label></div></div></div>';
            } else {
                echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Portal User</label><div class="col-md-8"><div id=checked_2 class="form-control" disabled><i class="icon-checkbox-checked"></i></div></div></div></div>';
            }
            echo '</div>'; //.row

            echo '<div id="portal_div_2" ' . $style . ' class="well">';

            echo '<div class="row">';
            if ($o_addr[1]['USER_NAME'] == '' && $o_addr[1]['PASSWORD'] == '') {
                echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Username</label><div class="col-md-8">' . TextInput($o_addr[1]['USER_NAME'], 'values[people][OTHER][USER_NAME]', '', 'id=primary_username onkeyup="usercheck_init_mod(this,2)" ') . '<div id="ajax_output_2"></div></div></div></div>';
                echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Password</label><div class="col-md-8">' . TextInput($o_addr[1]['PASSWORD'], 'values[people][OTHER][PASSWORD]', '', 'id=primary_password onkeyup="passwordStrengthMod(this.value,2);validate_password_mod(this.value,2);"') . '<span id="passwordStrength2"></span></div></div></div>';
            } else {
                echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Username</label><div class="col-md-8"><div id=uname2>' . $o_addr[1]['USER_NAME'] . '</div></div></div></div>';
                echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Password</label><div class="col-md-8"><div id=pwd2>' . str_repeat('*', strlen($o_addr[1]['PASSWORD'])) . '</div></div></div></div>';
            }
            echo '</div>'; //.row

            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">User Profile</label><div class="col-md-8">' . SelectInput($o_addr[1]['PROFILE_ID'], 'values[people][OTHER][PROFILE_ID]', '', $parent_user_prof_options, FALSE, ' id=oth_prof_id') . '</div></div></div>';
            echo '</div>'; //.row

            echo '</div>'; //#portal_div_2

            echo '<div id="portal_hidden_div_2" ></div>';

            echo '<hr/>';

            echo '<div class="row">';
            echo '<div class="col-md-12"><div class="form-group"><label class="control-label text-right col-md-2">Address Line 1</label><div class="col-md-10"><div class="input-group">' . TextInput($o_addr[1]['ADDRESS'], 'values[student_address][OTHER][STREET_ADDRESS_1]', '', '');
            if ($o_addr[1]['ADDRESS_ID'] != '' && $o_addr[1]['ADDRESS_ID'] != '0') {
                $display_address = urlencode($o_addr[1]['ADDRESS'] . ', ' . ($o_addr[1]['CITY'] ? ' ' . $o_addr[1]['CITY'] . ', ' : '') . $o_addr[1]['STATE'] . ($o_addr[1]['ZIPCODE'] ? ' ' . $o_addr[1]['ZIPCODE'] : ''));
                $link = 'http://google.com/maps?q=' . $display_address;
                echo '<span class="input-group-btn">';
                echo '<A class="btn btn-danger" HREF="javascript:void(0);" onclick=\'window.open("' . $link . '","","scrollbars=yes,resizable=yes,width=800,height=700");\'><i class="icon-location4"></i>Map it</A>';
                echo '</span>';
            }
            echo '</div>';
            echo '</div></div></div>';
            echo '</div>'; //.row

            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Address Line 2</label><div class="col-md-8">' . TextInput($o_addr[1]['STREET'], 'values[student_address][OTHER][STREET_ADDRESS_2]', '', '') . '</div></div></div>';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">City</label><div class="col-md-8">' . TextInput($o_addr[1]['CITY'], 'values[student_address][OTHER][CITY]', '', '') . '</div></div></div>';
            echo '</div>'; //.row

            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">State</label><div class="col-md-8">' . TextInput($o_addr[1]['STATE'], 'values[student_address][OTHER][STATE]', '', '') . '</div></div></div>';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Zip/Postal Code</label><div class="col-md-8">' . TextInput($o_addr[1]['ZIPCODE'], 'values[student_address][OTHER][ZIPCODE]', '', '') . '</div></div></div>';
            echo '</div>'; //.row

            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">College Bus Pick-up</label><div class="col-md-8">' . CheckboxInputMod($o_addr[1]['BUS_PICKUP'], 'values[student_address][OTHER][BUS_PICKUP]', '', 'CHECKED', $new, '<i class="icon-checkbox-checked"></i>', '<i class="icon-checkbox-unchecked"></i>') . '</div></div></div>';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">College Bus Drop-off</label><div class="col-md-8">' . CheckboxInputMod($o_addr[1]['BUS_DROPOFF'], 'values[student_address][OTHER][BUS_DROPOFF]', '', 'CHECKED', $new, '<i class="icon-checkbox-checked"></i>', '<i class="icon-checkbox-unchecked"></i>') . '</div></div></div>';
            echo '</div>'; //.row

            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Bus No</label><div class="col-md-8">' . TextInput($o_addr[1]['BUS_NO'], 'values[student_address][OTHER][BUS_NO]', '', 'class=cell_small') . '</div></div></div>';
            echo '</div>'; //.row
        } else {

            $extra = "id=" . "'values[people][OTHER][RELATIONSHIP]'";

            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-5">This is an Emergency Contact</label><div class="col-md-1"><input type=hidden name=values[people][OTHER][IS_EMERGENCY_HIDDEN] id=IS_EMERGENCY_HIDDEN value="Y">' . CheckboxInputMod($o_addr[1]['IS_EMERGENCY'], 'values[people][OTHER][IS_EMERGENCY]', '', 'CHECKED', $new, '<i class="icon-checkbox-checked"></i>', '<i class="icon-checkbox-unchecked"></i>') . '</div></div></div>';
            echo '</div>'; //.row

            if (User('PROFILE') != 'teacher') {
//                echo '<div class="row">';
//                echo '<div class="col-md-8"><div class="form-group"><label class="control-label text-right col-md-3">Relationship to Student<span class=text-danger>*</span></label><div class="col-md-9"><div class="input-group">' . SelectInput($o_addr[1]['RELATIONSHIP'], 'values[people][OTHER][RELATIONSHIP]', '', $relation_options, 'N/A', $extra) . '<span class="input-group-btn"><input type="button" name="lookup" class="btn btn-primary" value="Lookup" onclick="javascript:window.open(\'ForWindow.php?modname=' . $_REQUEST['modname'] . '&modfunc=lookup&type=other&ajax=' . $_REQUEST['ajax'] . '&add_id=new&address_id=' . $_REQUEST['address_id'] . '\',\'blank\',\'resizable=yes,scrollbars=yes,width=600,height=600\');return false;"></span></div></div></div></div>';
//                echo '</div>'; //.row
                echo '<div class="col-md-8"><div class="form-group"><label class="control-label text-right col-md-3">Relationship to Student<span class=text-danger>*</span></label><div class="col-md-9"><div class="input-group">' . SelectInput($o_addr[1]['RELATIONSHIP'], 'values[people][OTHER][RELATIONSHIP]', '', $relation_options, 'N/A', $extra) . '<span class="input-group-btn"><input type=button  data-toggle="modal" class=btn btn-primary  name=lookup  value=Lookup onclick=modal_parenttype(\'other\',\'new\');></span></div></div></div></div>';
            }

            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">First Name<span class=text-danger>*</span></label><div class="col-md-8">' . _makePeopleInput($o_addr[1]['FIRST_NAME'], 'people', 'FIRST_NAME', 'OTHER', '', 'id=oth_fname') . '</div></div></div>';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Last Name<span class=text-danger>*</span></label><div class="col-md-8">' . _makePeopleInput($o_addr[1]['LAST_NAME'], 'people', 'LAST_NAME', 'OTHER', '', 'id=oth_lname') . '</div></div></div>';
            echo '</div>'; //.row

            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Home Phone</label><div class="col-md-8"> ' . TextInput($o_addr[1]['HOME_PHONE'], 'values[people][OTHER][HOME_PHONE]', '', 'id=oth_hphone') . '</div></div></div>';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Work Phone</label><div class="col-md-8">' . TextInput($o_addr[1]['WORK_PHONE'], 'values[people][OTHER][WORK_PHONE]', '', 'id=oth_wphone') . '</div></div></div>';
            echo '</div>'; //.row

            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Mobile Phone</label><div class="col-md-8">' . TextInput($o_addr[1]['CELL_PHONE'], 'values[people][OTHER][CELL_PHONE]', '', 'id=oth_cphone') . '</div></div></div>';
            if ($o_addr[1]['PERSON_ID'] == '') {
                echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Email<span class=text-danger>*</span></label><div class="col-md-8">' . TextInput($o_addr[1]['EMAIL'], 'values[people][OTHER][EMAIL]', '', 'autocomplete=off id=oth_email onkeyup=peoplecheck_email(this,2,0); ') . '<p class="help-block" id="email_2"></p></div></div></div>';
            } else {
                echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Email<span class=text-danger>*</span></label><div class="col-md-8">' . TextInput($o_addr[1]['EMAIL'], 'values[people][OTHER][EMAIL]', '', 'autocomplete=off id=oth_email onkeyup=peoplecheck_email(this,2,' . $o_addr[1]['PERSON_ID'] . ') ') . '<p class="help-block" id="email_2"></p></div></div></div>';
            }
            echo '</div>'; //.row

            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Custody of Student</label><div class="col-md-8">' . CheckboxInputMod($o_addr[1]['CUSTODY'], 'values[people][OTHER][CUSTODY]', '', 'CHECKED', $new, '<i class="icon-checkbox-checked"></i>', '<i class="icon-checkbox-unchecked"></i>') . '</div></div></div>';
            echo '</div>'; //.row
            if ($o_addr[1]['USER_NAME'] == '') {
                $portal_check = '';
                $style = 'style="display:none"';
            } else {
                $portal_check = 'checked="checked"';
                $style = '';
            }
            echo'<input type=hidden id=hidden_other name=hidden_other>';
            echo '<input type="hidden" id=oth_val_pass value="Y">';
            echo '<input type="hidden" id=oth_val_user value="Y">';
            echo '<input type="hidden" id=val_email_2 name=val_email_2 value="Y">';

            echo '<div class="well m-b-15">';
            echo '<div class="row">';
            if ($portal_check == '') {
                echo '<div class="col-md-6"><div class="col-md-8"><label class="checkbox-inline checkbox-switch switch-success switch-xs"><input type="checkbox" name="other_portal" value="Y" id="portal_2" onClick="portal_toggle(2);" ' . $portal_check . '/><span></span>Portal User</label></div></div>';
            } else {
                echo '<div class="col-md-6"><label class="control-label text-right col-md-4">Portal User</label><div class="col-md-8"><div class="form-control" disabled><i class="icon-checkbox-checked"></i></div></div></div>';
            }
            echo '</div>'; //.row

            echo '<div id="portal_div_2" ' . $style . ' class="m-t-15">';
            echo '<div class="row">';
            if ($o_addr[1]['USER_NAME'] == '' && $o_addr[1]['PASSWORD'] == '') {
                echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Username</label><div class="col-md-8">' . TextInput($o_addr[1]['USER_NAME'], 'values[people][OTHER][USER_NAME]', '', 'id=other_username onkeyup="usercheck_init_mod(this,2)" ') . '<div id="ajax_output_2"></div></div></div></div>';
                echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Password</label><div class="col-md-8">' . TextInput($o_addr[1]['PASSWORD'], 'values[people][OTHER][PASSWORD]', '', 'id=other_password onkeyup="passwordStrengthMod(this.value,2);validate_password_mod(this.value,2);"') . '<p class="help-block" id="passwordStrength2"></p></div></div></div>';
            } else {
                echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Username</label><div class="col-md-8">' . $o_addr[1]['USER_NAME'] . '</div></div></div>';
                echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Password</label><div class="col-md-8">' . str_repeat('*', strlen($o_addr[1]['PASSWORD'])) . '</div></div></div>';
            }
            echo '</div>'; //.row

            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">User Profile</label><div class="col-md-8">' . SelectInput($o_addr[1]['PROFILE_ID'], 'values[people][OTHER][PROFILE_ID]', '', $parent_user_prof_options, FALSE, ' id=oth_prof_id') . '</div></div></div>';
            echo '</div>'; //.row

            echo '</div>'; //#portal_div_2
            echo '</div>'; //.well

            echo '<div id="portal_hidden_div_2" ></div>';

            echo '<div class="row">';
            echo '<div class="col-md-12"><div class="form-group"><label class="control-label text-right col-md-2">Address<span class=text-danger>*</span></label><div class="col-md-10"><label class="radio-inline"><input type="radio" id="ros" name="r7" value="Y" onClick="addn_hidediv();" checked>Same as Student\'s Home Address</label><label class="radio-inline"><input type="radio" id="ron" name="r7" value="N" onClick="addn_showdiv();">Add New Address</label></div></div></div>';
            echo '</div>'; //.row

            echo '<div id="addn_hideShow" style="display:none" class="well">';

            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Address Line 1</label><div class="col-md-8">' . TextInput($o_addr[1]['ADDRESS'], 'values[student_address][OTHER][STREET_ADDRESS_1]', '', 'id=oth_address') . '</div></div></div>';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Address Line 2</label><div class="col-md-8">' . TextInput($o_addr[1]['STREET'], 'values[student_address][OTHER][STREET_ADDRESS_2]', '', 'id=oth_street') . '</div></div></div>';
            echo '</div>'; //.row

            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">City</label><div class="col-md-8">' . TextInput($o_addr[1]['CITY'], 'values[student_address][OTHER][CITY]', '', 'id=oth_city') . '</div></div></div>';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">State</label><div class="col-md-8">' . TextInput($o_addr[1]['STATE'], 'values[student_address][OTHER][STATE]', '', 'id=oth_state') . '</div></div></div>';
            echo '</div>'; //.row

            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Zip/Postal Code</label><div class="col-md-8">' . TextInput($o_addr[1]['ZIPCODE'], 'values[student_address][OTHER][ZIPCODE]', '', 'id=oth_zip') . '</div></div></div>';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">Bus No</label><div class="col-md-8">' . TextInput($o_addr[1]['BUS_NO'], 'values[student_address][OTHER][BUS_NO]', '', 'id=oth_busno class=cell_small') . '</div></div></div>';
            echo '</div>'; //.row

            echo '<div class="row">';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">College Bus Pick-up</label><div class="col-md-8">' . CheckboxInputMod($o_addr[1]['BUS_PICKUP'], 'values[student_address][OTHER][BUS_PICKUP]', '', 'CHECKED', $new, '<i class="icon-checkbox-checked"></i>', '<i class="icon-checkbox-unchecked"></i>', false) . '</div></div></div>';
            echo '<div class="col-md-6"><div class="form-group"><label class="control-label text-right col-md-4">College Bus Drop-off</label><div class="col-md-8">' . CheckboxInputMod($o_addr[1]['BUS_DROPOFF'], 'values[student_address][OTHER][BUS_DROPOFF]', '', 'CHECKED', $new, '<i class="icon-checkbox-checked"></i>', '<i class="icon-checkbox-unchecked"></i>', false) . '</div></div></div>';
            echo '</div>'; //.row

            echo '</div>'; //#addn_hideShow
        }
    }



    if ($_REQUEST['person_id'] == 'new') {
        echo '</TD></TR>';
        echo '</TABLE>'; // end of table 2
    }
    unset($_REQUEST['address_id']);
    unset($_REQUEST['person_id']);
}

echo '</div>'; //.col-md-8
echo '</div>'; //.row

if ($_REQUEST['nfunc'] == 'status') {

    if ($_REQUEST['button'] == 'Select') {

        $sel_staff = $_REQUEST['staff'];

        $people_info = DBGet(DBQuery('SELECT * FROM people WHERE STAFF_ID=' . $sel_staff));
        $people_info = $people_info[1];

        foreach ($people_info as $pi => $pd)
            $people_info[$pi] = str_replace("'", "\'", $pd);
        unset($pi);
        unset($pd);
        $parent_type = DBGet(DBQuery('SELECT RELATIONSHIP FROM students_join_people WHERE PERSON_ID=' . $sel_staff));
        $parent_type = $parent_type[1]['RELATIONSHIP'];
        $options_RET = DBGet(DBQuery('SELECT DISTINCT RELATIONSHIP FROM students_join_people'));

        $relation_options = array('Father' => 'Father', 'Mother' => 'Mother', 'Step Mother' => 'Step Mother', 'Step Father' => 'Step Father', 'Grandmother' => 'Grandmother', 'Grandfather' => 'Grandfather', 'Legal Guardian' => 'Legal Guardian', 'Other Family Member' => 'Other Family Member', '---' => '---');
        foreach ($options_RET as $k => $v) {
            $key = $parent_type;
        }

        $options['---'] = '---';
        foreach ($relation_options as $k => $v) {
            if ($v == $parent_type)
                $option .= '<option selected>' . $v . '</option>';
            else {
                $option .= '<option>' . $v . '</option>';
            }
        }

        $parent_prof_options_arr = DBGet(DBQuery('SELECT id,profile,title FROM user_profiles WHERE profile = \'' . 'parent' . '\''));

        foreach ($parent_prof_options_arr as $i => $j) {
            $s_user_profs_ids_arr[] = $parent_prof_options_arr[$i]['ID'];
        }

        $s_user_profs_id = implode(',', $s_user_profs_ids_arr);

        $people_address = DBGet(DBQuery('SELECT * FROM student_address WHERE PEOPLE_ID=' . $sel_staff));
        $people_address = $people_address[1];
        foreach ($people_address as $pi => $pd)
            $people_address[$pi] = str_replace("'", "\'", $pd);
        unset($pi);
        unset($pd);

        $people_loginfo = DBGet(DBQuery('SELECT * FROM login_authentication WHERE USER_ID=' . $sel_staff . ' AND PROFILE_ID in (' . $s_user_profs_id . ')'));
        $people_loginfo = $people_loginfo[1];

        $parent_prof_options['---'] = '---';
        foreach ($parent_prof_options_arr as $pnm_arr) {
            if ($people_loginfo['PROFILE_ID'] == $pnm_arr['ID'])
                $parent_prof_options .= '<option selected value=' . $pnm_arr['ID'] . '>' . $pnm_arr['TITLE'] . '</option>';
            else
                $parent_prof_options .= '<option value=' . $pnm_arr['ID'] . '>' . $pnm_arr['TITLE'] . '</option>';
        }


        $check_rec = DBGet(DBQuery('SELECT COUNT(*) as REC_EX,sa.id as address_id FROM  students_join_people sp,student_address sa WHERE sp.college_roll_no=sa.college_roll_no and UPPER(sp.EMERGENCY_TYPE)=\'' . strtoupper($_REQUEST['type']) . '\' AND sp.COLLEGE_ROLL_NO=' . $_REQUEST['college_roll_no']));
        if ($check_rec[1]['REC_EX'] == 0) {
            $_REQUEST['address_id'] = 'new';
        } else
            $_REQUEST['address_id'] = $check_rec[1]['ADDRESS_ID'];
        if ($_REQUEST['type'] == 'primary') {
//                                

            if ($people_loginfo['USERNAME'] != '') {
                if ($_REQUEST['address_id'] == 'new')
                    echo '<SCRIPT language=javascript>document.getElementById(\'values[people][PRIMARY][FIRST_NAME]\').value=\'' . $people_info['FIRST_NAME'] . '\';document.getElementById(\'values[people][PRIMARY][RELATIONSHIP]\').value=\'' . $key . '\';document.getElementById(\'values[people][PRIMARY][LAST_NAME]\').value=\'' . $people_info['LAST_NAME'] . '\';document.getElementById(\'values[people][PRIMARY][HOME_PHONE]\').value=\'' . $people_info['HOME_PHONE'] . '\';document.getElementById(\'hidden_primary\').value=\'' . $sel_staff . '\';document.getElementById(\'values[people][PRIMARY][WORK_PHONE]\').value=\'' . $people_info['WORK_PHONE'] . '\';document.getElementById(\'values[people][PRIMARY][CELL_PHONE]\').value=\'' . $people_info['CELL_PHONE'] . '\';document.getElementById(\'values[people][PRIMARY][EMAIL]\').value=\'' . $people_info['EMAIL'] . '\';document.getElementById(\'portal_div_1\').style.display=\'block\';document.getElementById(\'portal_1\').checked=true;document.getElementById(\'values[people][PRIMARY][USER_NAME]\').value=\'' . $people_loginfo['USERNAME'] . '\';var pwd=document.getElementById(\'values[people][PRIMARY][PASSWORD]\'); var pwd2= pwd.cloneNode(false);pwd2.type=\'password\';pwd.parentNode.replaceChild(pwd2,pwd);document.getElementById(\'values[people][PRIMARY][PASSWORD]\').value=\'' . $people_loginfo['PASSWORD'] . '\';document.getElementById(\'pri_prof_id\').value=\'' . $people_loginfo['PROFILE_ID'] . '\';</script>';
                else {
//alert(document.getElementById(\'divvalues[people][PRIMARY][RELATIONSHIP]\').innerHTML=\'mmmmm\');
                    echo '<SCRIPT language=javascript>'
                    . 'document.getElementById(\'divvalues[people][PRIMARY][RELATIONSHIP]\').innerHTML=\'<SELECT id=inputvalues[people][PRIMARY][RELATIONSHIP] name=values[people][PRIMARY][RELATIONSHIP] />' . $option . '</SELECT> \';'
                    . 'document.getElementById(\'divvalues[people][PRIMARY][FIRST_NAME]\').innerHTML=\'<INPUT type=text id=inputvalues[people][PRIMARY][FIRST_NAME] name=values[people][PRIMARY][FIRST_NAME] class=cell_medium size=2 /> \';'
                    . 'document.getElementById(\'divvalues[people][PRIMARY][LAST_NAME]\').innerHTML=\'<INPUT type=text id=inputvalues[people][PRIMARY][LAST_NAME] name=values[people][PRIMARY][LAST_NAME] class=cell_medium size=2 /> \';'
                    . 'document.getElementById(\'divvalues[people][PRIMARY][EMAIL]\').innerHTML=\'<INPUT type=text id=inputvalues[people][PRIMARY][EMAIL] name=values[people][PRIMARY][EMAIL] class=cell_medium size=2 onkeyup="peoplecheck_email(this,1,0);"/> \';'
                    . 'var workphone=document.getElementById(\'divvalues[people][PRIMARY][WORK_PHONE]\'); if(workphone!=null) workphone.innerHTML=\'<INPUT type=text id=inputvalues[people][PRIMARY][WORK_PHONE] name=values[people][PRIMARY][WORK_PHONE] class=cell_medium size=2 /> \';'
                    . 'var homephone=document.getElementById(\'divvalues[people][PRIMARY][HOME_PHONE]\'); if(homephone!=null) homephone.innerHTML=\'<INPUT type=text id=inputvalues[people][PRIMARY][HOME_PHONE] name=values[people][PRIMARY][HOME_PHONE] class=cell_medium size=2 /> \';'
                    . 'var cellphone=document.getElementById(\'divvalues[people][PRIMARY][CELL_PHONE]\'); if(cellphone!=null) cellphone.innerHTML=\'<INPUT type=text id=inputvalues[people][PRIMARY][CELL_PHONE] name=values[people][PRIMARY][CELL_PHONE] class=cell_medium size=2 /> \';'
                    . '</script>';
                    echo '<SCRIPT language=javascript>'
                    . 'document.getElementById(\'selected_pri_parent\').value=' . $sel_staff . ';'
                    . 'document.getElementById(\'hidden_primary\').value=\'' . $sel_staff . '\';'
                    . 'document.getElementById(\'inputvalues[people][PRIMARY][FIRST_NAME]\').value=\'' . $people_info['FIRST_NAME'] . '\';'
                    . 'document.getElementById(\'inputvalues[people][PRIMARY][LAST_NAME]\').value=\'' . $people_info['LAST_NAME'] . '\';'
                    . 'document.getElementById(\'inputvalues[people][PRIMARY][EMAIL]\').value=\'' . $people_info['EMAIL'] . '\';'
                    . 'var home_phone=document.getElementById(\'inputvalues[people][PRIMARY][HOME_PHONE]\'); if(home_phone==null) home_phone=document.getElementById(\'values[people][PRIMARY][HOME_PHONE]\');  home_phone.value=\'' . $people_info['HOME_PHONE'] . '\';'
                    . 'var work_phone=document.getElementById(\'inputvalues[people][PRIMARY][WORK_PHONE]\'); if(work_phone==null) work_phone=document.getElementById(\'values[people][PRIMARY][WORK_PHONE]\');  work_phone.value=\'' . $people_info['WORK_PHONE'] . '\';'
                    . 'var cell_phone=document.getElementById(\'inputvalues[people][PRIMARY][CELL_PHONE]\'); if(cell_phone==null) cell_phone=document.getElementById(\'values[people][PRIMARY][CELL_PHONE]\');  cell_phone.value=\'' . $people_info['CELL_PHONE'] . '\';'
                    . 'var portal=document.getElementById(\'portal_1\'); if(portal!=null) { document.getElementById(\'portal_1\').checked=true;document.getElementById(\'values[people][PRIMARY][USER_NAME]\').value=\'' . $people_loginfo['USERNAME'] . '\';'
                    . 'var pwd=document.getElementById(\'values[people][PRIMARY][PASSWORD]\'); '
                    . 'var pwd2= pwd.cloneNode(false);pwd2.type=\'password\';'
                    . 'pwd.parentNode.replaceChild(pwd2,pwd);'
                    . 'document.getElementById(\'values[people][PRIMARY][PASSWORD]\').value=\'' . $people_loginfo['PASSWORD'] . '\';document.getElementById(\'divvalues[people][PRIMARY][PROFILE_ID]\').innerHTML=\'<SELECT id=pri_prof_id name=values[people][PRIMARY][PROFILE_ID] />' . $parent_prof_options . '</SELECT> \';} else {document.getElementById(\'uname1\').innerHTML=\'' . $people_loginfo['USERNAME'] . '\'; document.getElementById(\'pwd1\').innerHTML=\'' . str_repeat('*', strlen($people_loginfo['PASSWORD'])) . '\';document.getElementById(\'divvalues[people][PRIMARY][PROFILE_ID]\').innerHTML=\'<SELECT id=pri_prof_id name=values[people][PRIMARY][PROFILE_ID] />' . $parent_prof_options . '</SELECT> \'; } </script>';
//                                   .'</script>';
                }
            } else {
//                                    echo '<script>alert(\'okkk\')</script>';
                if ($_REQUEST['address_id'] == 'new')
                    echo '<SCRIPT language=javascript>document.getElementById(\'values[people][PRIMARY][FIRST_NAME]\').value=\'' . $people_info['FIRST_NAME'] . '\';document.getElementById(\'values[people][PRIMARY][RELATIONSHIP]\').value=\'' . $key . '\';document.getElementById(\'values[people][PRIMARY][LAST_NAME]\').value=\'' . $people_info['LAST_NAME'] . '\';document.getElementById(\'values[people][PRIMARY][HOME_PHONE]\').value=\'' . $people_info['HOME_PHONE'] . '\';document.getElementById(\'values[people][PRIMARY][WORK_PHONE]\').value=\'' . $people_info['WORK_PHONE'] . '\';document.getElementById(\'hidden_primary\').value=\'' . $sel_staff . '\';document.getElementById(\'values[people][PRIMARY][CELL_PHONE]\').value=\'' . $people_info['CELL_PHONE'] . '\';document.getElementById(\'values[people][PRIMARY][EMAIL]\').value=\'' . $people_info['EMAIL'] . '\';document.getElementById(\'portal_1\').checked=false;document.getElementById(\'values[people][PRIMARY][USER_NAME]\').value=\'\';document.getElementById(\'values[people][PRIMARY][PASSWORD]\').value=\'\';document.getElementById(\'portal_div_1\').style.display=\'none\';</script>';
                else {

                    echo '<SCRIPT language=javascript></script>';

                    echo '<SCRIPT language=javascript>';

                    echo 'document.getElementById(\'divvalues[people][PRIMARY][RELATIONSHIP]\').innerHTML=\'<SELECT id=inputvalues[people][PRIMARY][RELATIONSHIP] name=values[people][PRIMARY][RELATIONSHIP] />' . $option . '</SELECT> \';'
                    . 'document.getElementById(\'divvalues[people][PRIMARY][FIRST_NAME]\').innerHTML=\'<INPUT type=text id=inputvalues[people][PRIMARY][FIRST_NAME] name=values[people][PRIMARY][FIRST_NAME] class=cell_medium size=2 /> \';'
                    . 'document.getElementById(\'divvalues[people][PRIMARY][LAST_NAME]\').innerHTML=\'<INPUT type=text id=inputvalues[people][PRIMARY][LAST_NAME]  name = values[people][PRIMARY][LAST_NAME] class=cell_medium size=2 /> \';'
                    . 'document.getElementById(\'divvalues[people][PRIMARY][EMAIL]\').innerHTML=\'<INPUT type=text id=inputvalues[people][PRIMARY][EMAIL] class=cell_medium size=2 onkeyup="peoplecheck_email(this,1,0);"/> \';'
                    . 'var workphone=document.getElementById(\'divvalues[people][PRIMARY][WORK_PHONE]\'); if(workphone!=null) workphone.innerHTML=\'<INPUT type=text id=inputvalues[people][PRIMARY][WORK_PHONE] name=values[people][PRIMARY][WORK_PHONE] class=cell_medium size=2 /> \';'
                    . 'var homephone=document.getElementById(\'divvalues[people][PRIMARY][HOME_PHONE]\'); if(homephone!=null) homephone.innerHTML=\'<INPUT type=text id=inputvalues[people][PRIMARY][HOME_PHONE] name=values[people][PRIMARY][HOME_PHONE]  class=cell_medium size=2 /> \';'
                    . 'var cellphone=document.getElementById(\'divvalues[people][PRIMARY][CELL_PHONE]\'); if(cellphone!=null) cellphone.innerHTML=\'<INPUT type=text id=inputvalues[people][PRIMARY][CELL_PHONE] name=values[people][PRIMARY][CELL_PHONE] class=cell_medium size=2 /> \';'
                    . '</script>';
                    echo '<SCRIPT language=javascript>'
                    . 'document.getElementById(\'selected_pri_parent\').value=' . $sel_staff . ';'
                    . 'document.getElementById(\'hidden_primary\').value=\'' . $sel_staff . '\';'
                    . 'document.getElementById(\'inputvalues[people][PRIMARY][FIRST_NAME]\').value=\'' . $people_info['FIRST_NAME'] . '\';'
                    . 'document.getElementById(\'inputvalues[people][PRIMARY][LAST_NAME]\').value=\'' . $people_info['LAST_NAME'] . '\';'
                    . 'document.getElementById(\'inputvalues[people][PRIMARY][EMAIL]\').value=\'' . $people_info['EMAIL'] . '\';'
                    . 'var home_phone=document.getElementById(\'inputvalues[people][PRIMARY][HOME_PHONE]\'); if(home_phone==null) home_phone=document.getElementById(\'values[people][PRIMARY][HOME_PHONE]\');  home_phone.value=\'' . $people_info['HOME_PHONE'] . '\';'
                    . 'var work_phone=document.getElementById(\'inputvalues[people][PRIMARY][WORK_PHONE]\'); if(work_phone==null) work_phone=document.getElementById(\'values[people][PRIMARY][WORK_PHONE]\');  work_phone.value=\'' . $people_info['WORK_PHONE'] . '\';'
                    . 'var cell_phone=document.getElementById(\'inputvalues[people][PRIMARY][CELL_PHONE]\'); if(cell_phone==null) cell_phone=document.getElementById(\'values[people][PRIMARY][CELL_PHONE]\');  cell_phone.value=\'' . $people_info['CELL_PHONE'] . '\';'
                    . 'var portal=document.getElementById(\'portal_1\'); if(portal!=null) { document.getElementById(\'portal_1\').checked=false;'
                    . 'document.getElementById(\'values[people][PRIMARY][USER_NAME]\').value=\'\';'
                    . 'document.getElementById(\'values[people][PRIMARY][PASSWORD]\').value=\'\'; document.getElementById(\'portal_div_1\').style.display=\'none\';} else { var chk1=document.getElementById(\'checked_1\');  if(chk1!=null) chk1.innerHTML=\'<input type="checkbox" width="25" name="primary_portal" value="Y" id="portal_1" onClick="portal_toggle(1);" /> \' ; 
                                  var uname1=document.getElementById(\'uname1\'); if(uname1!=null) uname1.innerHTML=\'<INPUT type=text name=values[people][PRIMARY][USER_NAME] id=values[people][PRIMARY][USER_NAME] class=cell_medium onblur="usercheck_init_mod(this,1);" name=values[people][PRIMARY][USER_NAME] class=cell_medium size=2 /><div id="ajax_output_1"></div> \' ;
                                  var pwd1=document.getElementById(\'pwd1\'); if(pwd1!=null) pwd1.innerHTML=\'<INPUT type=password name=values[people][PRIMARY][PASSWORD] id=values[people][PRIMARY][PASSWORD] class=cell_medium onkeyup="passwordStrengthMod(this.value,1);" onblur="validate_password_mod(this.value,1);"  /><span id="passwordStrength1"></span> \';document.getElementById(\'portal_div_1\').style.display=none;} </script>';

//                                                .'</script>';
                }
            }
        } elseif ($_REQUEST['type'] == 'secondary') {
            if ($people_loginfo['USERNAME'] != '') {
                if ($_REQUEST['address_id'] == 'new')
                    echo '<SCRIPT language=javascript>document.getElementById(\'values[people][SECONDARY][FIRST_NAME]\').value=\'' . $people_info['FIRST_NAME'] . '\';document.getElementById(\'values[people][SECONDARY][RELATIONSHIP]\').value=\'' . $key . '\';document.getElementById(\'values[people][SECONDARY][LAST_NAME]\').value=\'' . $people_info['LAST_NAME'] . '\';document.getElementById(\'values[people][SECONDARY][HOME_PHONE]\').value=\'' . $people_info['HOME_PHONE'] . '\';document.getElementById(\'hidden_secondary\').value=\'' . $sel_staff . '\';document.getElementById(\'values[people][SECONDARY][WORK_PHONE]\').value=\'' . $people_info['WORK_PHONE'] . '\';document.getElementById(\'values[people][SECONDARY][CELL_PHONE]\').value=\'' . $people_info['CELL_PHONE'] . '\';document.getElementById(\'values[people][SECONDARY][EMAIL]\').value=\'' . $people_info['EMAIL'] . '\';document.getElementById(\'portal_div_2\').style.display=\'block\';document.getElementById(\'portal_2\').checked=true;document.getElementById(\'values[people][SECONDARY][USER_NAME]\').value=\'' . $people_loginfo['USERNAME'] . '\';var pwd=document.getElementById(\'values[people][SECONDARY][PASSWORD]\'); var pwd2= pwd.cloneNode(false);pwd2.type=\'password\';pwd.parentNode.replaceChild(pwd2,pwd);document.getElementById(\'values[people][SECONDARY][PASSWORD]\').value=\'' . $people_loginfo['PASSWORD'] . '\';document.getElementById(\'sec_prof_id\').value=\'' . $people_loginfo['PROFILE_ID'] . '\';</script>';
                else {
                    echo '<SCRIPT language=javascript>'
                    . 'document.getElementById(\'divvalues[people][SECONDARY][RELATIONSHIP]\').innerHTML=\'<SELECT id=inputvalues[people][SECONDARY][RELATIONSHIP] name=values[people][SECONDARY][RELATIONSHIP] />' . $option . '</SELECT> \';'
                    . 'document.getElementById(\'divvalues[people][SECONDARY][FIRST_NAME]\').innerHTML=\'<INPUT type=text id=inputvalues[people][SECONDARY][FIRST_NAME] name=values[people][SECONDARY][FIRST_NAME] class=cell_medium size=2 /> \';'
                    . 'document.getElementById(\'divvalues[people][SECONDARY][LAST_NAME]\').innerHTML=\'<INPUT type=text id=inputvalues[people][SECONDARY][LAST_NAME] name=values[people][SECONDARY][LAST_NAME] class=cell_medium size=2 /> \';'
                    . 'document.getElementById(\'divvalues[people][SECONDARY][EMAIL]\').innerHTML=\'<INPUT type=text id=inputvalues[people][SECONDARY][EMAIL] name= values[people][SECONDARY][EMAIL] class=cell_medium size=2 onkeyup="peoplecheck_email(this,2,0);"/> \';'
                    . 'var workphone=document.getElementById(\'divvalues[people][SECONDARY][WORK_PHONE]\'); if(workphone!=null) workphone.innerHTML=\'<INPUT type=text id=inputvalues[people][SECONDARY][WORK_PHONE] name=values[people][SECONDARY][WORK_PHONE] class=cell_medium size=2 /> \';'
                    . 'var homephone=document.getElementById(\'divvalues[people][SECONDARY][HOME_PHONE]\'); if(homephone!=null) homephone.innerHTML=\'<INPUT type=text id=inputvalues[people][SECONDARY][HOME_PHONE] name=values[people][SECONDARY][HOME_PHONE] class=cell_medium size=2 /> \';'
                    . 'var cellphone=document.getElementById(\'divvalues[people][SECONDARY][CELL_PHONE]\'); if(cellphone!=null) cellphone.innerHTML=\'<INPUT type=text id=inputvalues[people][SECONDARY][CELL_PHONE] name=[people][SECONDARY][CELL_PHONE] class=cell_medium size=2 /> \';'
                    . '</script>';
                    echo '<SCRIPT language=javascript>'
                    . 'document.getElementById(\'selected_sec_parent\').value=' . $sel_staff . ';' . 'document.getElementById(\'hidden_secondary\').value=\'' . $sel_staff . '\';'
                    . 'document.getElementById(\'inputvalues[people][SECONDARY][FIRST_NAME]\').value=\'' . $people_info['FIRST_NAME'] . '\';'
                    . 'document.getElementById(\'inputvalues[people][SECONDARY][LAST_NAME]\').value=\'' . $people_info['LAST_NAME'] . '\';'
                    . 'var home_phone=document.getElementById(\'inputvalues[people][SECONDARY][HOME_PHONE]\'); if(home_phone==null) home_phone=document.getElementById(\'values[people][SECONDARY][HOME_PHONE]\');  home_phone.value=\'' . $people_info['HOME_PHONE'] . '\';'
                    . 'var work_phone=document.getElementById(\'inputvalues[people][SECONDARY][WORK_PHONE]\'); if(work_phone==null) work_phone=document.getElementById(\'values[people][SECONDARY][WORK_PHONE]\');  work_phone.value=\'' . $people_info['WORK_PHONE'] . '\';'
                    . 'var cell_phone=document.getElementById(\'inputvalues[people][SECONDARY][CELL_PHONE]\'); if(cell_phone==null) cell_phone=document.getElementById(\'values[people][SECONDARY][CELL_PHONE]\');  cell_phone.value=\'' . $people_info['CELL_PHONE'] . '\';'
                    . 'var sec_email=document.getElementById(\'inputvalues[people][SECONDARY][EMAIL]\'); if(sec_email==null) sec_email=document.getElementById(\'values[people][SECONDARY][EMAIL]\');   sec_email.value=\'' . $people_info['EMAIL'] . '\';document.getElementById(\'portal_div_2\').style.display=\'block\';'
                    . 'var portal=document.getElementById(\'portal_2\'); if(portal!=null) { document.getElementById(\'portal_2\').checked=true;document.getElementById(\'values[people][SECONDARY][USER_NAME]\').value=\'' . $people_loginfo['USERNAME'] . '\';'
                    . 'var pwd=document.getElementById(\'values[people][SECONDARY][PASSWORD]\'); '
                    . 'var pwd2= pwd.cloneNode(false);pwd2.type=\'password\';'
                    . 'pwd.parentNode.replaceChild(pwd2,pwd);'
                    . 'document.getElementById(\'values[people][SECONDARY][PASSWORD]\').value=\'' . $people_loginfo['PASSWORD'] . '\';document.getElementById(\'divvalues[people][SECONDARY][PROFILE_ID]\').innerHTML=\'<SELECT id=sec_prof_id name=values[people][SECONDARY][PROFILE_ID] />' . $parent_prof_options . '</SELECT> \';} else { document.getElementById(\'uname2\').innerHTML=\'' . $people_loginfo['USERNAME'] . '\'; document.getElementById(\'pwd2\').innerHTML=\'' . str_repeat('*', strlen($people_loginfo['PASSWORD'])) . '\';document.getElementById(\'divvalues[people][SECONDARY][PROFILE_ID]\').innerHTML=\'<SELECT id=sec_prof_id name=values[people][SECONDARY][PROFILE_ID] />' . $parent_prof_options . '</SELECT> \'; } </script>';
                }
            } else {
                if ($_REQUEST['address_id'] == 'new')
                    echo '<SCRIPT language=javascript>document.getElementById(\'values[people][SECONDARY][FIRST_NAME]\').value=\'' . $people_info['FIRST_NAME'] . '\';document.getElementById(\'values[people][SECONDARY][RELATIONSHIP]\').value=\'' . $key . '\';document.getElementById(\'values[people][SECONDARY][LAST_NAME]\').value=\'' . $people_info['LAST_NAME'] . '\';document.getElementById(\'values[people][SECONDARY][HOME_PHONE]\').value=\'' . $people_info['HOME_PHONE'] . '\';document.getElementById(\'hidden_secondary\').value=\'' . $sel_staff . '\';document.getElementById(\'values[people][SECONDARY][WORK_PHONE]\').value=\'' . $people_info['WORK_PHONE'] . '\';document.getElementById(\'values[people][SECONDARY][CELL_PHONE]\').value=\'' . $people_info['CELL_PHONE'] . '\';document.getElementById(\'values[people][SECONDARY][EMAIL]\').value=\'' . $people_info['EMAIL'] . '\';document.getElementById(\'portal_div_2\').style.display=\'none\';document.getElementById(\'portal_2\').checked=false;document.getElementById(\'values[people][SECONDARY][USER_NAME]\').value=\'\';document.getElementById(\'values[people][SECONDARY][PASSWORD]\').value=\'\';</script>';
                else {
                    echo '<SCRIPT language=javascript>alert(\'ok\');'
                    . 'document.getElementById(\'divvalues[people][SECONDARY][RELATIONSHIP]\').innerHTML=\'<SELECT id=inputvalues[people][SECONDARY][RELATIONSHIP] name=values[people][SECONDARY][RELATIONSHIP] />' . $option . '</SELECT>\';'
                    . 'document.getElementById(\'divvalues[people][SECONDARY][FIRST_NAME]\').innerHTML=\'<INPUT type=text id=inputvalues[people][SECONDARY][FIRST_NAME] name=values[people][SECONDARY][FIRST_NAME] class=cell_medium size=2 /> \';'
                    . 'document.getElementById(\'divvalues[people][SECONDARY][LAST_NAME]\').innerHTML=\'<INPUT type=text id=inputvalues[people][SECONDARY][LAST_NAME] name=values[people][SECONDARY][LAST_NAME] class=cell_medium size=2 /> \';'
                    . 'document.getElementById(\'divvalues[people][SECONDARY][EMAIL]\').innerHTML=\'<INPUT type=text id=inputvalues[people][SECONDARY][EMAIL]  name=values[people][SECONDARY][EMAIL] class=cell_medium size=2 onkeyup="peoplecheck_email(this,2,0);"/> \';'
                    . 'var workphone=document.getElementById(\'divvalues[people][SECONDARY][WORK_PHONE]\'); if(workphone!=null) workphone.innerHTML=\'<INPUT type=text id=inputvalues[people][SECONDARY][WORK_PHONE] name=values[people][SECONDARY][WORK_PHONE] class=cell_medium size=2 /> \';'
                    . 'var homephone=document.getElementById(\'divvalues[people][SECONDARY][HOME_PHONE]\'); if(homephone!=null) homephone.innerHTML=\'<INPUT type=text id=inputvalues[people][SECONDARY][HOME_PHONE] name=values[people][SECONDARY][HOME_PHONE] class=cell_medium size=2 /> \';'
                    . 'var cellphone=document.getElementById(\'divvalues[people][SECONDARY][CELL_PHONE]\'); if(cellphone!=null) cellphone.innerHTML=\'<INPUT type=text id=inputvalues[people][SECONDARY][CELL_PHONE] name=values[people][SECONDARY][CELL_PHONE] class=cell_medium size=2 /> \';'
                    . '</script>';
                    echo '<SCRIPT language=javascript>'
                    . 'document.getElementById(\'selected_sec_parent\').value=' . $sel_staff . ';' . 'document.getElementById(\'hidden_secondary\').value=\'' . $sel_staff . '\';'
                    . 'document.getElementById(\'inputvalues[people][SECONDARY][FIRST_NAME]\').value=\'' . $people_info['FIRST_NAME'] . '\';'
                    . 'document.getElementById(\'inputvalues[people][SECONDARY][LAST_NAME]\').value=\'' . $people_info['LAST_NAME'] . '\';'
                    . 'var sec_email=document.getElementById(\'inputvalues[people][SECONDARY][EMAIL]\'); if(sec_email==null) sec_email=document.getElementById(\'values[people][SECONDARY][EMAIL]\'); sec_email.value=\'' . $people_info['EMAIL'] . '\';'
                    . 'var home_phone=document.getElementById(\'inputvalues[people][SECONDARY][HOME_PHONE]\'); if(home_phone==null) home_phone=document.getElementById(\'values[people][SECONDARY][HOME_PHONE]\');  home_phone.value=\'' . $people_info['HOME_PHONE'] . '\';'
                    . 'var work_phone=document.getElementById(\'inputvalues[people][SECONDARY][WORK_PHONE]\'); if(work_phone==null) work_phone=document.getElementById(\'values[people][SECONDARY][WORK_PHONE]\');  work_phone.value=\'' . $people_info['WORK_PHONE'] . '\';'
                    . 'var cell_phone=document.getElementById(\'inputvalues[people][SECONDARY][CELL_PHONE]\'); if(cell_phone==null) cell_phone=document.getElementById(\'values[people][SECONDARY][CELL_PHONE]\');  cell_phone.value=\'' . $people_info['CELL_PHONE'] . '\';'
                    . 'var portal=document.getElementById(\'portal_2\'); if(portal!=null) { document.getElementById(\'portal_2\').checked=false;'
                    . 'document.getElementById(\'values[people][SECONDARY][USER_NAME]\').value=\'\';'
                    . 'document.getElementById(\'values[people][SECONDARY][PASSWORD]\').value=\'\';document.getElementById(\'portal_div_2\').style.display=\'none\';} else { var chk2=document.getElementById(\'checked_2\'); if(chk2!=null) chk2.innerHTML=\'<input type="checkbox" name="secondary_portal" value="Y" id="portal_2" onClick="portal_toggle(2);" /> \' ; 
                                  var uname2=document.getElementById(\'uname2\'); if(uname2!=null) uname2.innerHTML=\'<INPUT type=text name=values[people][SECONDARY][USER_NAME] id=values[people][SECONDARY][USER_NAME] class=cell_medium onblur="usercheck_init_mod(this,2);" name=values[people][SECONDARY][USER_NAME] class=cell_medium size=2 /><div id="ajax_output_2"></div> \' ;
                                   var pwd2=document.getElementById(\'pwd2\'); if(pwd2!=null) pwd2.innerHTML=\'<INPUT type=password name=values[people][SECONDARY][PASSWORD] id=values[people][SECONDARY][PASSWORD] class=cell_medium onkeyup="passwordStrengthMod(this.value,1);" onblur="validate_password_mod(this.value,2);"  /><span id="passwordStrength2"></span> \';document.getElementById(\'portal_div_2\').style.display=\'none\'; }</script>';
                }
            }
        } else {
            if ($people_loginfo['USERNAME'] != '') {

                if ($_REQUEST['add_id'] == 'new')
                    echo '<SCRIPT language=javascript>document.getElementById(\'values[people][OTHER][FIRST_NAME]\').value=\'' . $people_info['FIRST_NAME'] . '\';document.getElementById(\'values[people][OTHER][RELATIONSHIP]\').value=\'' . $key . '\';document.getElementById(\'values[people][OTHER][LAST_NAME]\').value=\'' . $people_info['LAST_NAME'] . '\';document.getElementById(\'values[people][OTHER][HOME_PHONE]\').value=\'' . $people_info['HOME_PHONE'] . '\';document.getElementById(\'values[people][OTHER][WORK_PHONE]\').value=\'' . $people_info['WORK_PHONE'] . '\';document.getElementById(\'hidden_other\').value=\'' . $sel_staff . '\';document.getElementById(\'values[people][OTHER][CELL_PHONE]\').value=\'' . $people_info['CELL_PHONE'] . '\';document.getElementById(\'values[people][OTHER][EMAIL]\').value=\'' . $people_info['EMAIL'] . '\';document.getElementById(\'portal_div_2\').style.display=\'block\';document.getElementById(\'portal_2\').checked=true;document.getElementById(\'values[people][OTHER][USER_NAME]\').value=\'' . $people_loginfo['USERNAME'] . '\';var pwd=document.getElementById(\'values[people][OTHER][PASSWORD]\'); var pwd2= pwd.cloneNode(false);pwd2.type=\'password\';pwd.parentNode.replaceChild(pwd2,pwd);document.getElementById(\'values[people][OTHER][PASSWORD]\').value=\'' . $people_loginfo['PASSWORD'] . '\';document.getElementById(\'oth_prof_id\').value=\'' . $people_loginfo['PROFILE_ID'] . '\';document.getElementById(\'addn_hideShow\').style.display =\'block\';document.getElementById(\'ron\').checked=true;document.getElementById(\'values[student_address][OTHER][STREET_ADDRESS_1]\').value=\'' . $people_address['STREET_ADDRESS_1'] . '\';document.getElementById(\'values[student_address][OTHER][STREET_ADDRESS_2]\').value=\'' . $people_address['STREET_ADDRESS_2'] . '\';document.getElementById(\'values[student_address][OTHER][CITY]\').value=\'' . $people_address['CITY'] . '\';document.getElementById(\'values[student_address][OTHER][STATE]\').value=\'' . $people_address['STATE'] . '\';document.getElementById(\'values[student_address][OTHER][ZIPCODE]\').value=\'' . $people_address['ZIPCODE'] . '\';' . ($people_address['BUS_PICKUP'] == 'Y' ? 'document.getElementById(\'values[student_address][OTHER][BUS_PICKUP]\').checked=true;' : '') . ($people_address['BUS_DROPOFF'] == 'Y' ? 'document.getElementById(\'values[student_address][OTHER][BUS_DROPOFF]\').checked=true;' : '') . 'document.getElementById(\'oth_busno\').value=\'' . $people_address['BUS_NO'] . '\';document.getElementById(\'portal_2\').checked=true;document.getElementById(\'portal_div_2\').style.display=\'block\';document.getElementById(\'other_username\').value=\'' . $people_loginfo['USERNAME'] . '\';document.getElementById(\'other_password\').value=\'' . $people_loginfo['PASSWORD'] . '\';document.getElementById(\'oth_prof_id\').value=\'' . $people_loginfo['PROFILE_ID'] . '\';window.close();</script>';
                else {
                    echo '<SCRIPT language=javascript>'
                    . 'document.getElementById(\'divvalues[people][OTHER][RELATIONSHIP]\').innerHTML=\'<SELECT id=inputvalues[people][OTHER][RELATIONSHIP] name=values[people][OTHER][RELATIONSHIP] />' . $option . '</SELECT> \';'
                    . 'document.getElementById(\'person_f_' . $_REQUEST['add_id'] . '\').innerHTML=\'<table><tr><td><INPUT type=text id=inputvalues[people][OTHER][FIRST_NAME] name=values[people][OTHER][FIRST_NAME] class=cell_medium size=2 /></td></tr></table>\';'
                    . 'document.getElementById(\'person_l_' . $_REQUEST['add_id'] . '\').innerHTML=\'<table><tr><td><INPUT type=text id=inputvalues[people][OTHER][LAST_NAME] name=values[people][OTHER][LAST_NAME] class=cell_medium size=2 /></td></tr></table>\';'
                    . 'document.getElementById(\'divvalues[people][OTHER][EMAIL]\').innerHTML=\'<INPUT type=text id=inputvalues[people][OTHER][EMAIL] name= values[people][OTHER][EMAIL] class=cell_medium size=2 onkeyup="peoplecheck_email(this,2,0);"/> \';'
                    . 'var workphone=document.getElementById(\'divvalues[people][OTHER][WORK_PHONE]\'); if(workphone!=null) workphone.innerHTML=\'<INPUT type=text id=inputvalues[people][OTHER][WORK_PHONE] name=values[people][OTHER][WORK_PHONE] class=cell_medium size=2 /> \';'
                    . 'var homephone=document.getElementById(\'divvalues[people][OTHER][HOME_PHONE]\'); if(homephone!=null) homephone.innerHTML=\'<INPUT type=text id=inputvalues[people][OTHER][HOME_PHONE] name=values[people][OTHER][HOME_PHONE] class=cell_medium size=2 /> \';'
                    . 'var cellphone=document.getElementById(\'divvalues[people][OTHER][CELL_PHONE]\'); if(cellphone!=null) cellphone.innerHTML=\'<INPUT type=text id=inputvalues[people][OTHER][CELL_PHONE] name=[people][OTHER][CELL_PHONE] class=cell_medium size=2 /> \';'
                    . '</script>';
                    echo '<SCRIPT language=javascript>'
                    . 'document.getElementById(\'selected_oth_parent\').value=' . $sel_staff . ';'
                    . 'document.getElementById(\'inputvalues[people][OTHER][FIRST_NAME]\').value=\'' . $people_info['FIRST_NAME'] . '\';'
                    . 'document.getElementById(\'inputvalues[people][OTHER][LAST_NAME]\').value=\'' . $people_info['LAST_NAME'] . '\';'
                    . 'var home_phone=document.getElementById(\'inputvalues[people][OTHER][HOME_PHONE]\'); if(home_phone==null) home_phone=document.getElementById(\'values[people][OTHER][HOME_PHONE]\');  home_phone.value=\'' . $people_info['HOME_PHONE'] . '\';'
                    . 'var work_phone=document.getElementById(\'inputvalues[people][OTHER][WORK_PHONE]\'); if(work_phone==null) work_phone=document.getElementById(\'values[people][OTHER][WORK_PHONE]\');  work_phone.value=\'' . $people_info['WORK_PHONE'] . '\';'
                    . 'var cell_phone=document.getElementById(\'inputvalues[people][OTHER][CELL_PHONE]\'); if(cell_phone==null) cell_phone=document.getElementById(\'values[people][OTHER][CELL_PHONE]\');  cell_phone.value=\'' . $people_info['CELL_PHONE'] . '\';'
                    . 'document.getElementById(\'inputvalues[people][OTHER][EMAIL]\').value=\'' . $people_info['EMAIL'] . '\';document.getElementById(\'portal_div_2\').style.display=\'block\';'
                    . 'var portal=document.getElementById(\'portal_2\'); if(portal!=null) { document.getElementById(\'portal_2\').checked=true;document.getElementById(\'values[people][OTHER][USER_NAME]\').value=\'' . $people_loginfo['USERNAME'] . '\';'
                    . 'var pwd=document.getElementById(\'values[people][OTHER][PASSWORD]\'); '
                    . 'var pwd2= pwd.cloneNode(false);pwd2.type=\'password\';'
                    . 'pwd.parentNode.replaceChild(pwd2,pwd);'
                    . 'document.getElementById(\'values[people][OTHER][PASSWORD]\').value=\'' . $people_loginfo['PASSWORD'] . '\';document.getElementById(\'divvalues[people][OTHER][PROFILE_ID]\').innerHTML=\'<SELECT id=oth_prof_id name=values[people][OTHER][PROFILE_ID] />' . $parent_prof_options . '</SELECT> \'; } else { document.getElementById(\'uname2\').innerHTML=\'' . $people_loginfo['USERNAME'] . '\'; document.getElementById(\'pwd2\').innerHTML=\'' . str_repeat('*', strlen($people_loginfo['PASSWORD'])) . '\';document.getElementById(\'divvalues[people][OTHER][PROFILE_ID]\').innerHTML=\'<SELECT id=oth_prof_id name=values[people][OTHER][PROFILE_ID] />' . $parent_prof_options . '</SELECT> \'; }</script>';
                }
            } else {
                if ($_REQUEST['add_id'] == 'new')
                    echo '<SCRIPT language=javascript>document.getElementById(\'values[people][OTHER][FIRST_NAME]\').value=\'' . $people_info['FIRST_NAME'] . '\';document.getElementById(\'values[people][OTHER][RELATIONSHIP]\').selectedIndex=\'' . $key . '\';document.getElementById(\'values[people][OTHER][LAST_NAME]\').value=\'' . $people_info['LAST_NAME'] . '\';document.getElementById(\'values[people][OTHER][HOME_PHONE]\').value=\'' . $people_info['HOME_PHONE'] . '\';document.getElementById(\'values[people][OTHER][WORK_PHONE]\').value=\'' . $people_info['WORK_PHONE'] . '\';document.getElementById(\'values[people][OTHER][CELL_PHONE]\').value=\'' . $people_info['CELL_PHONE'] . '\';document.getElementById(\'values[people][OTHER][EMAIL]\').value=\'' . $people_info['EMAIL'] . '\';document.getElementById(\'portal_div_2\').style.display=\'none\';document.getElementById(\'portal_2\').checked=false;document.getElementById(\'values[people][OTHER][USER_NAME]\').value=\'\';document.getElementById(\'values[people][OTHER][PASSWORD]\').value=\'\';document.getElementById(\'addn_hideShow\').style.display =\'block\';document.getElementById(\'ron\').checked=true;document.getElementById(\'values[student_address][OTHER][STREET_ADDRESS_1]\').value=\'' . $people_address['STREET_ADDRESS_1'] . '\';document.getElementById(\'values[student_address][OTHER][STREET_ADDRESS_2]\').value=\'' . $people_address['STREET_ADDRESS_2'] . '\';document.getElementById(\'values[student_address][OTHER][CITY]\').value=\'' . $people_address['CITY'] . '\';document.getElementById(\'values[student_address][OTHER][STATE]\').value=\'' . $people_address['STATE'] . '\';document.getElementById(\'values[student_address][OTHER][ZIPCODE]\').value=\'' . $people_address['ZIPCODE'] . '\';' . ($people_address['BUS_PICKUP'] == 'Y' ? 'document.getElementById(\'values[student_address][OTHER][BUS_PICKUP]\').checked=true;' : '') . ($people_address['BUS_DROPOFF'] == 'Y' ? 'document.getElementById(\'values[student_address][OTHER][BUS_DROPOFF]\').checked=true;' : '') . 'document.getElementById(\'oth_busno\').value=\'' . $people_address['BUS_NO'] . '\';window.close();</script>';
                else {
                    echo '<SCRIPT language=javascript>'
                    . 'document.getElementById(\'divvalues[people][OTHER][RELATIONSHIP]\').innerHTML=\'<SELECT id=inputvalues[people][OTHER][RELATIONSHIP] name=values[people][OTHER][RELATIONSHIP] />' . $option . '</SELECT>\';'
                    . 'document.getElementById(\'person_f_' . $_REQUEST['add_id'] . '\').innerHTML=\'<table><tr><td><INPUT type=text id=inputvalues[people][OTHER][FIRST_NAME] name=values[people][OTHER][FIRST_NAME] class=cell_medium size=2 /></td></tr></table>\';'
                    . 'document.getElementById(\'person_l_' . $_REQUEST['add_id'] . '\').innerHTML=\'<table><tr><td><INPUT type=text id=inputvalues[people][OTHER][LAST_NAME] name=values[people][OTHER][LAST_NAME] class=cell_medium size=2 /></td></tr></table>\';'
                    . 'document.getElementById(\'divvalues[people][OTHER][EMAIL]\').innerHTML=\'<INPUT type=text id=inputvalues[people][OTHER][EMAIL]  name=values[people][OTHER][EMAIL] class=cell_medium size=2 onkeyup="peoplecheck_email(this,2,0);"/> \';'
                    . 'var workphone=document.getElementById(\'divvalues[people][OTHER][WORK_PHONE]\'); if(workphone!=null) workphone.innerHTML=\'<INPUT type=text id=inputvalues[people][OTHER][WORK_PHONE] name=values[people][OTHER][WORK_PHONE] class=cell_medium size=2 /> \';'
                    . 'var homephone=document.getElementById(\'divvalues[people][OTHER][HOME_PHONE]\'); if(homephone!=null) homephone.innerHTML=\'<INPUT type=text id=inputvalues[people][OTHER][HOME_PHONE] name=values[people][OTHER][HOME_PHONE] class=cell_medium size=2 /> \';'
                    . 'var cellphone=document.getElementById(\'divvalues[people][OTHER][CELL_PHONE]\'); if(cellphone!=null) cellphone.innerHTML=\'<INPUT type=text id=inputvalues[people][OTHER][CELL_PHONE] name=values[people][OTHER][CELL_PHONE] class=cell_medium size=2 /> \';'
                    . 'var chk2=document.getElementById(\'checked_2\'); if(chk2!=null) chk2.innerHTML=\'<input type="checkbox" name="other_portal" value="Y" id="portal_2" onClick="portal_toggle(2);" /> \' ;'
                    . 'var uname2=document.getElementById(\'uname2\'); if(uname2!=null) uname2.innerHTML=\'<INPUT type=text id=values[people][OTHER][USER_NAME] class=cell_medium size=2 /> \' ;'
                    . 'var pwd2=document.getElementById(\'pwd2\'); if(pwd2!=null) pwd2.innerHTML=\'<INPUT type=text id=values[people][OTHER][PASSWORD] class=cell_medium size=2  /> \' '
                    . '</script>';
                    echo '<SCRIPT language=javascript>'
                    . 'document.getElementById(\'selected_oth_parent\').value=' . $sel_staff . ';'
                    . 'document.getElementById(\'values[people][OTHER][FIRST_NAME]\').value=\'' . $people_info['FIRST_NAME'] . '\';'
                    . 'document.getElementById(\'values[people][OTHER][LAST_NAME]\').value=\'' . $people_info['LAST_NAME'] . '\';'
                    . 'document.getElementById(\'inputvalues[people][OTHER][EMAIL]\').value=\'' . $people_info['EMAIL'] . '\';'
                    . 'var home_phone=document.getElementById(\'inputvalues[people][OTHER][HOME_PHONE]\'); if(home_phone==null) home_phone=document.getElementById(\'values[people][OTHER][HOME_PHONE]\');  home_phone.value=\'' . $people_info['HOME_PHONE'] . '\';'
                    . 'var work_phone=document.getElementById(\'inputvalues[people][OTHER][WORK_PHONE]\'); if(work_phone==null) work_phone=document.getElementById(\'values[people][OTHER][WORK_PHONE]\');  work_phone.value=\'' . $people_info['WORK_PHONE'] . '\';'
                    . 'var cell_phone=document.getElementById(\'inputvalues[people][OTHER][CELL_PHONE]\'); if(cell_phone==null) cell_phone=document.getElementById(\'values[people][OTHER][CELL_PHONE]\');  cell_phone.value=\'' . $people_info['CELL_PHONE'] . '\';'
                    . 'var portal=document.getElementById(\'portal_2\'); if(portal!=null) { document.getElementById(\'portal_2\').checked=false;'
                    . 'document.getElementById(\'values[people][OTHER][USER_NAME]\').value=\'\';'
                    . 'document.getElementById(\'values[people][OTHER][PASSWORD]\').value=\'\'; document.getElementById(\'portal_div_2\').style.display=\'none\';} else { var chk2=document.getElementById(\'checked_2\'); if(chk2!=null) chk2.innerHTML=\'<input type="checkbox" name="other_portal" value="Y" id="portal_2" onClick="portal_toggle(2);" /> \' ; 
                                  var uname2=document.getElementById(\'uname2\'); if(uname2!=null) uname2.innerHTML=\'<INPUT type=text name=values[people][OTHER][USER_NAME] id=values[people][OTHER][USER_NAME] class=cell_medium onblur="usercheck_init_mod(this,2);" size=2 /><div id="ajax_output_2"></div> \' ;
                                   var pwd2=document.getElementById(\'pwd2\'); if(pwd2!=null) pwd2.innerHTML=\'<INPUT type=password name=values[people][OTHER][PASSWORD] id=values[people][OTHER][PASSWORD] class=cell_medium onkeyup="passwordStrengthMod(this.value,1);" onblur="validate_password_mod(this.value,2);"/><span id="passwordStrength2"></span> \';document.getElementById(\'portal_div_2\').style.display=\'none\'; }</script>';
                }
            }
        }
        echo '<SCRIPT language=javascript>window.close();</script>';
    }
    if ($_REQUEST['button'] == 'Cancel') {
        echo '<SCRIPT language=javascript>window.close();</script>';
    }
}

function _makePeopleInput($value, $table, $column, $opt, $title = '', $options = '') {
    global $THIS_RET;

    if ($column == 'MIDDLE_NAME')
        $options = '';
    if ($_REQUEST['person_id'] == 'new')
        $div = false;
    else
        $div = true;



    return TextInput($value, "values[$table][$opt][$column]", $title, $options, false);
}

function _makeAutoSelect($column, $table, $opt, $values = '', $options = array()) {
    if ($opt != '')
        $where = ' WHERE EMERGENCY_TYPE=\'' . $opt . '\' ';
    else
        $where = '';

    $options_RET = DBGet(DBQuery('SELECT DISTINCT ' . $column . ',upper(' . $column . ') AS `KEY` FROM ' . $table . ' ' . $where . ' ORDER BY `KEY`'));

    // add the 'new' option, is also the separator
    $options['---'] = '---';
    // add values already in table
    if (count($options_RET))
        foreach ($options_RET as $option)
            if ($option[$column] != '' && !$options[$option[$column]])
                $options[$option[$column]] = array($option[$column], '<FONT color=blue>' . $option[$column] . '</FONT>');
    // make sure values are in the list
    if (is_array($values)) {
        foreach ($values as $value)
            if ($value[$column] != '' && !$options[$value[$column]])
                $options[$value[$column]] = array($value[$column], '<FONT color=blue>' . $value[$column] . '</FONT>');
    }
    else
    if ($values != '' && !$options[$values])
        $options[$values] = array($values, '<FONT color=blue>' . $values . '</FONT>');

    return $options;
}

function _makeAutoSelectInputX($value, $column, $table, $opt, $title, $select, $id = '', $div = true) {
    $extra = 'id=' . "values[$table][$opt]" . ($id ? "[$id]" : '') . "[$column]";
    
    $extra = "id=" . "values[$table][$opt]" . "[$column]";
    if($opt == 'SECONDARY'){
    $extra .= " onchange=addseccheck_button();";
    }
    if ($column == 'CITY' || $column == 'MAIL_CITY')
        $options = 'maxlength=60';
    if ($column == 'STATE' || $column == 'MAIL_STATE')
        $options = 'size=3 maxlength=10';
    elseif ($column == 'ZIPCODE' || $column == 'MAIL_ZIPCODE')
        $options = 'maxlength=10';
    else
        $options = 'maxlength=100';

    if ($value != '---' && count($select) > 1)
        return SelectInput($value, "values[$table][$opt]" . ($id ? "[$id]" : '') . "[$column]", $title, $select, 'N/A', $extra, $div);
    else
        return TextInput($value == '---' ? array('---', '<FONT color=red>---</FONT>') : $value, "values[$table][$opt]" . ($id ? "[$id]" : '') . "[$column]", $title, $options, $div);
}

?>