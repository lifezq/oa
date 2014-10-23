/**
 * @filename lifezq.js
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://www.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-8-5  15:53:58
 * @version 1.0
 */

//判断输入密码的类型  
function CharMode(iN){  
    if (iN>=48 && iN <=57) //数字  
        return 1;  
    if (iN>=65 && iN <=90) //大写  
        return 2;  
    if (iN>=97 && iN <=122) //小写  
        return 4;  
    else  
        return 8;   
}  
//bitTotal函数  
//计算密码模式  
function bitTotal(num){  
    modes=0;  
    for (i=0;i<4;i++){  
        if (num & 1) modes++;  
        num>>>=1;  
    }  
    return modes;  
}  
//返回强度级别  
function checkStrong(sPW){  
    if (sPW.length<=4)  
        return 0; //密码太短  
    Modes=0;  
    for (i=0;i<sPW.length;i++){  
        //密码模式  
        Modes|=CharMode(sPW.charCodeAt(i));  
    }  
    return bitTotal(Modes);  
}  
  
//显示颜色  
function pwStrength(pwd,num){  
    O_color="#ccc";  
    L_color="#FF0000";  
    M_color="#FF9900";  
    H_color="#33CC00";  
    if (pwd==null||pwd==''){  
        Lcolor=Mcolor=Hcolor=O_color;  
    }  
    else{  
        S_level=checkStrong(pwd);  
        switch(S_level) {  
            case 0:
                Lcolor=Mcolor=Hcolor=O_color;  
            case 1:
                Lcolor=L_color;  
                Mcolor=Hcolor=O_color;  
                break;  
            case 2:
                Lcolor=Mcolor=M_color;  
                Hcolor=O_color;  
                break;  
            default:
                Lcolor=Mcolor=Hcolor=H_color;  
        }  
    }  
    if(num == 0){
        document.getElementById("pwd1_strong_l").style.background=Lcolor;  
        document.getElementById("pwd1_strong_m").style.background=Mcolor;  
        document.getElementById("pwd1_strong_h").style.background=Hcolor;   
    }else if(num == 1){
        document.getElementById("pwd2_strong_l").style.background=Lcolor;  
        document.getElementById("pwd2_strong_m").style.background=Mcolor;  
        document.getElementById("pwd2_strong_h").style.background=Hcolor;
    }else{
        var pwd1 = document.getElementById("UserUPassword").value;
        var pwd2 = document.getElementById("UserUPassword2").value;
        if(pwd1 != pwd2){
            $('#pwd_is_equal').html('&nbsp;<font color=#f00>再次密码不一致</font>');
            $('#create_user_submit').attr('disabled',true)
        }else{
            $('#pwd_is_equal').html(' ');
            $('#create_user_submit').attr('disabled',false)
        }
    }
                  
    return;  
}  
var selectUEmail = [];
function companyUserEmail(val){
    var isAdd = true;
    for(var i=0;i<selectUEmail.length;i++){
        if(selectUEmail[i] == val){
            selectUEmail.splice(i,1);
            isAdd = false;
        }
    }
    
    if(isAdd ==  true)
        selectUEmail.push(val)
    //    alert(selectUEmail)
    $('#EmailEmComeTo').val(selectUEmail.join(';'));
}
function checkAll(){
    var _len = $('input:checkbox').length;
    for(var i=0;i<_len;i++){
        if($('input:checkbox:eq('+i+')').attr('checked')){
            $('input:checkbox:eq('+i+')').attr('checked',false)
        }else{
            $('input:checkbox:eq('+i+')').attr('checked',true)
        }
    }
}
/*
 * @param input_type  0:all  1:input  2:checkbox   3:select  4:textarea
 * @param ignore      要忽略掉的数据
 */
function checkSubmit(input_type,ignore){
    switch(input_type){
        case 'all':
            break;
        case 'input':
            break;
        case 'checkbox':
            var _len = $('input:checkbox');
            for(var i=0;i<_len;i++){
                if($('input:checkbox:eq('+i+')').val()){
                    return true;
                    break;
                }
            }
            return false;
            break;
        case 'select':
            break;
        case 'textarea':
            break;
        default:
            break;
    }
}

