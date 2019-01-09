<?php
/**
 * Created by PhpStorm.
 * User: Radon
 * Date: 30.12.2018
 * Time: 14:48
 */

session_start();


if (!empty($_SESSION['log']) && $_SESSION['log'] == 'logged') {
    if( !($_SESSION['level'] == 'regs' || $_SESSION['level'] == 'admin' ||  $_SESSION['level'] == 'root') ){
        header("refresh:0 url=error.php");die();
    }
}else{
    header("refresh:0 url=index.php");
    die();
}
?>
<!DOCTYPE html>
<html lang="en">

<?php include_once 'header.php'?>
<body>
<div class="bodyContent">

    <?php include_once 'topmenu.php'?>
    <?php include_once 'leftmenu.php'?>

    <div class="main">
        <!--block of registration-->
        <div class="block" style="width: 50%">
            <div class="blockTitle">
                Registration
            </div>
            <div class="blockContent" style="padding-bottom: 70px" >

                <form>
                    <div class="divInputReg">
                        <input type="text" class="inputReg" id="offerID" required autocomplete="off">
                        <div class="labelInputReg" >Shaxsiy_ID</div>
                    </div>
                    <div class="divInputReg">
                        <input type="text" class="inputReg" id="RegID" required autocomplete="off">
                        <div class="labelInputReg" >Registration_ID</div>
                    </div>
                    <div class="divInputReg">
                        <input type="text" class="inputReg" id="inputName" required autocomplete="off" minlength="2" maxlength="16">
                        <div class="labelInputReg">Name</div>
                    </div>
                    <div class="divInputReg">
                        <input type="text" class="inputReg" id="inputSurName" required autocomplete="off" minlength="2" maxlength="16">
                        <div class="labelInputReg">Surname</div>
                    </div>
                    <div class="divInputReg">
                        <input type="text" class="inputReg" id="inputFatherName" required autocomplete="off" minlength="2" maxlength="16">
                        <div class="labelInputReg">Father`s name</div>
                    </div>
                    <div class="divInputReg">
                        <input type="text" class="inputReg" id="inputTelNum" required autocomplete="off">
                        <div class="labelInputReg">Telephone number</div>
                    </div>
                    <div class="divInputReg">
                        <select type="text" class="inputReg" id="inputRegion" required>
                            <option value="Toshkent">Toshkent</option>
                            <option value="Buxoro">Buxoro</option>
                            <option value="Navoiy">Navoiy</option>
                            <option value="Sirdaryo">Sirdaryo</option>
                            <option value="Surxondaryo">Surxondaryo</option>
                            <option value="Qashqadaryo">Qashqadaryo</option>
                            <option value="Samarqand">Samarqand</option>
                            <option value="Xorazm">Xorazm</option>
                            <option value="Andijon">Andijon</option>
                            <option value="Farg`ona">Farg`ona</option>
                            <option value="Namangan">Namangan</option>
                            <option value="Jizzax">Jizzax</option>
                            <option value="Qoraqalpog`iston">Qoraqalpog`iston</option>
                        </select>
                        <div class="labelInputReg">Region</div>
                    </div>
                    <div class="divInputReg">
                        <input type="date" class="inputReg" id="inputBirthDay" required value="2000-01-01" max="2012-01-01" min="1920-01-01">
                        <div class="labelInputReg">Birthday</div>
                    </div>
                    <div class="divInputReg">
                        <input type="text" class="inputReg" id="inputPassportNum" required autocomplete="off">
                        <div class="labelInputReg">Passport series&number</div>
                    </div>
                    <div class="divInputReg">
                        <input type="text" class="inputReg" id="inputCardNum" required autocomplete="off" minlength="19" maxlength="19">
                        <div class="labelInputReg">Card number</div>
                    </div>
                    <div class="divInputReg">
                        <select type="text" class="inputReg" id="inputJinsi" required>
                            <option value="erkak">erkak</option>
                            <option value="ayol">ayol</option>
                        </select>
                        <div class="labelInputReg">Jinsi</div>
                    </div>
                    <div class="divInputReg">
                        <input type="password" class="inputReg" id="inputPassword" required autocomplete="off" minlength="5" maxlength="16">
                        <div class="labelInputReg">Password</div>
                    </div>
                    <div class="divInputReg">
                        <input type="password" class="inputReg" id="inputPassword2" required autocomplete="off" minlength="5" maxlength="16">
                        <div class="labelInputReg">Password(check)</div>
                    </div>
                    <input type="button" class="submitButton" id="submitButton" value="Submit">
                </form>

            </div>
        </div> <!--block of registration --- end --->

        <!--block of ajax user info-->
        <div class="block" style="width: 50%; text-align: center">

            <!--preLoader-->
            <div class="whiteFaceLoader"><img class="preLoaderReg" src="images/loader.svg"/> </div>

            <div class="blockTitle">
                SQL_Information_From_Data_Base <i class="fas fa-sync-alt" id="syncButton" style="cursor: pointer;"></i>
            </div>

            <div class="blockContent" >
                Shaxsiy_ID </br>
                <div id="nodeOffer"></div>
            </div>

            <div class="blockContent" >
                Registration_ID</br>
                <div id="nodeReg"></div>
            </div>

        </div> <!--block of ajax user info --- end --->

    </div> <!-- main end -->

</div>
</body>
<script src="js/imask.js"></script>
<script>
    var IDs = [false , false];
    window.onload = function () {
        var preLoader = 0; /*preloader erta yo'qolib qolmasligi uchun*/

        /*keyUP Listener for offer id*/
        $("#offerID").keyup(function (event) {
            preLoader++;    /*multiThreading-da preLoader-ni alohida ishga tushirish uchun*/
            $("div.whiteFaceLoader").show();        /*preLoader ON*/
            $.post("regx.php",{
                offerID: $("#offerID").val()
                },
                function (data,status) {
                    preLoader--; /*preLoader-ni boshqa patoklarga post zaproslar kelgandan keyin tugatish uchun*/
                    if (preLoader == 0)$("div.whiteFaceLoader").hide();     /*preLoader OFF*/
                    if (data == "error") {
                        IDs[0] = false;
                        // alert(data);
                        $("#nodeOffer").hide();
                    }else {
                        IDs[0] = true;
                        $("#nodeOffer").show();
                        $("#nodeOffer").html(data);
                    }

                }
            )
        });

        /*keyUP Listener for Registration id*/
        $("#RegID").keyup(function (event) {
            preLoader++;    /*multiThreading-da preLoader-ni alohida ishga tushirish uchun*/
            $("div.whiteFaceLoader").show();        /*preLoader ON*/
            $.post("regx.php",{
                    RegID: $("#RegID").val()
                },
                function (data,status) {
                    preLoader--; /*preLoader-ni boshqa patoklarga post zaproslar kelgandan keyin tugatish uchun*/
                    if (preLoader == 0)$("div.whiteFaceLoader").hide();     /*preLoader OFF*/
                    if (data == "error") {
                        IDs[1] = false;
                        // alert(data);
                        $("#nodeReg").hide();
                    }else {
                        IDs[1] = true;
                        $("#nodeReg").show();
                        $("#nodeReg").html(data);
                    }

                }
            )
        });


        $("#syncButton").click(function () {
            preLoader++;    /*multiThreading-da preLoader-ni alohida ishga tushirish uchun*/
            $("div.whiteFaceLoader").show();        /*preLoader ON*/
            $.post("regx.php",{
                    RegID: $("#RegID").val()
                },
                function (data,status) {
                    preLoader--; /*preLoader-ni boshqa patoklarga post zaproslar kelgandan keyin tugatish uchun*/
                    if (preLoader == 0)$("div.whiteFaceLoader").hide();     /*preLoader OFF*/
                    if (data == "error") {
                        IDs[1] = false;
                        // alert(data);
                        $("#nodeReg").hide();
                    }else {
                        IDs[1] = true;
                        $("#nodeReg").show();
                        $("#nodeReg").html(data);
                    }

                }
            )
        })
    }
</script>


<script>

    var offerID;
    var RegID;
    var Name;
    var SurName;
    var FatherName;
    var TelNum;
    var Region;
    var BirthDay;
    var PassportNum;
    var CardNum;
    var Jinsi;
    var Password;
    var xofferID        = false;
    var xRegID          = false;
    var xName           = false;
    var xSurName        = false;
    var xFatherName     = false;
    var xTelNum         = false;
    var xRegion         = false;
    var xBirthDay       = false;
    var xPassportNum    = false;
    var xCardNum        = false;
    var xJinsi          = false;
    var xPassword       = false;

    var acceptBorderColor = "#ff4b5a";
    var completeBorderColor = "#07d307";

    /*masks for form inputs*/
    var maskOfferID = new IMask( document.getElementById("offerID") , {
        mask: Number,  // enable number mask

        // other options are optional with defaults below
        scale: 0,  // digits after point, 0 for integers
        signed: false,  // disallow negative
        thousandsSeparator: '',  // any single char
        padFractionalZeros: false,  // if true, then pads zeros at end to the length of scale
        normalizeZeros: true,  // appends or removes zeros at ends
        radix: ',',  // fractional delimiter
        mapToRadix: ['.'],  // symbols to process as radix

        // additional number interval options (e.g.)
        min: 0,
        max: 9999999
    });
    var maskRegID = new IMask( document.getElementById("RegID") , {
        mask: Number,  // enable number mask

        // other options are optional with defaults below
        scale: 0,  // digits after point, 0 for integers
        signed: false,  // disallow negative
        thousandsSeparator: '',  // any single char
        padFractionalZeros: false,  // if true, then pads zeros at end to the length of scale
        normalizeZeros: true,  // appends or removes zeros at ends
        radix: ',',  // fractional delimiter
        mapToRadix: ['.'],  // symbols to process as radix

        // additional number interval options (e.g.)
        min: 0,
        max: 9999999
    });
    var maskTEL = new IMask(document.getElementById("inputTelNum"),{
        mask: '(00) 000-00-00' /*maskani optashash uchun mana buni ishlat -> maskTEL.unmaskedValue*/
    });
    var maskName = new IMask( document.getElementById("inputName") , {
        mask: 'aa[aaaaaaaaaaaaaa]'
    });
    var maskSurName = new IMask( document.getElementById("inputSurName") , {
        mask: 'aa[aaaaaaaaaaaaaa]'
    });
    var maskFatherName = new IMask( document.getElementById("inputFatherName") , {
        mask: 'aa[aaaaaaaaaaaaaa]'
    });
    var maskCardNum = new IMask( document.getElementById("inputCardNum") , {
        mask: '0000-0000-0000-0000'
    });
    var maskPassportNum = new IMask( document.getElementById("inputPassportNum") , {
        mask: 'aa 000 00 00'
    });


    /*Changing styles and xBool values for form inputs and FullFormChecking function*/
    maskOfferID.on('accept',function () {
        document.getElementById("offerID").style.borderColor = acceptBorderColor;
        xofferID = false;
    }).on('complete',function () {
        document.getElementById("offerID").style.borderColor = completeBorderColor;
        offerID = maskOfferID.unmaskedValue;
        xofferID = true;
    });
    maskRegID.on('accept',function () {
        document.getElementById("RegID").style.borderColor = acceptBorderColor;
        xRegID = false;
    }).on('complete',function () {
        document.getElementById("RegID").style.borderColor = completeBorderColor;
        RegID = maskRegID.unmaskedValue;
        xRegID = true;
    });
    maskTEL.on('accept',function () {
        document.getElementById("inputTelNum").style.borderColor = acceptBorderColor;
        xTelNum = false;
    }).on('complete',function () {
        document.getElementById("inputTelNum").style.borderColor = completeBorderColor;
        TelNum = maskTEL.unmaskedValue;
        xTelNum = true;
    });
    maskName.on('accept',function () {
        document.getElementById("inputName").style.borderColor = acceptBorderColor;
        xName = false;
    }).on('complete',function () {
        document.getElementById("inputName").style.borderColor = completeBorderColor;
        Name = maskName.unmaskedValue;
        xName = true;
    });
    maskSurName.on('accept',function () {
        document.getElementById("inputSurName").style.borderColor = acceptBorderColor;
        xSurName = false;
    }).on('complete',function () {
        document.getElementById("inputSurName").style.borderColor = completeBorderColor;
        SurName = maskSurName.unmaskedValue;
        xSurName = true;
    });
    maskFatherName.on('accept',function () {
        document.getElementById("inputFatherName").style.borderColor = acceptBorderColor;
        xFatherName = false;
    }).on('complete',function () {
        document.getElementById("inputFatherName").style.borderColor = completeBorderColor;
        FatherName = maskFatherName.unmaskedValue;
        xFatherName = true;
    });
    maskCardNum.on('accept',function () {
        document.getElementById("inputCardNum").style.borderColor = acceptBorderColor;
        xCardNum = false;
    }).on('complete',function () {
        document.getElementById("inputCardNum").style.borderColor = completeBorderColor;
        CardNum = maskCardNum.unmaskedValue;
        xCardNum = true;
    });
    maskPassportNum.on('accept',function () {
        document.getElementById("inputPassportNum").style.borderColor = acceptBorderColor;
        xPassportNum = false;
    }).on('complete',function () {
        document.getElementById("inputPassportNum").style.borderColor = completeBorderColor;
        PassportNum = maskPassportNum.unmaskedValue;
        xPassportNum = true;
    });
    var checked = false;
    function FullFormChecking(){
        checked = false
        Region = $("#inputRegion").val();
        BirthDay = $("#inputBirthDay").val();
        Jinsi = $("#inputJinsi").val();
        if ($("#inputPassword").val() !== $("#inputPassword2").val()){
            document.getElementById("inputPassword").style.borderColor  = acceptBorderColor;
            document.getElementById("inputPassword2").style.borderColor = acceptBorderColor;
            xPassword = false;
        }else{
            document.getElementById("inputPassword").style.borderColor  = completeBorderColor;
            document.getElementById("inputPassword2").style.borderColor = completeBorderColor;
            Password = $("#inputPassword").val();
            xPassword = true;
        }
        if ( /*input-larni to`g`ri to`ldirilganligiga tekshirish! mask-lardagi complete funksiyasi orqali tekshiriladi*/
            xofferID && xRegID && xName && IDs[0] === true && IDs[1] === true &&
            xSurName && xFatherName && xTelNum &&
            xPassportNum && xCardNum && xPassword
        ) { checked = true;
            alert(
                "ShaxsiyID:" + offerID + "\n" +
                "RegID:" + RegID + "\n" +
                "Name:" + Name + "\n" +
                "SurName:" + SurName + "\n" +
                "FatherName:" + FatherName + "\n" +
                "TelNum:" + TelNum + "\n" +
                "Region:" + Region + "\n" +
                "BirthDay:" + BirthDay + "\n" +
                "PassportNum:" + PassportNum + "\n" +
                "CardNum:" + CardNum + "\n" +
                "Jinsi:" + Jinsi + "\n" +
                "Password:" + Password
            );
        }
        return checked; /*XXXXXXXXXXXXXXXXXXXXXXXX*/
    }

    function POSTRegistration(){
        $.post("registration.php",{
                offerID:     offerID,
                RegID:       RegID,
                Name:        Name,
                SurName:     SurName,
                FatherName:  FatherName,
                TelNum:      TelNum,
                Region:      Region,
                BirthDay:    BirthDay,
                PassportNum: PassportNum,
                CardNum:     CardNum,
                Jinsi:       Jinsi,
                Password:    Password,
            },
            function (data,status) {
                if (data == "error") {
                    alert(data);
                }else{
                    alert(data);
                }

            }
        )
    }

    var alertMessage = "";
    $("input.submitButton").click(function () {
        alertMessage = "";
        if( FullFormChecking() && ($("#idl").text() === ' ' || $("#idr").text() === ' ')){
            if(confirm("You really?")){
                POSTRegistration();
            }
        }else{
            if ($("#idl").text() !== ' ' && $("#idr").text() !== ' ') {
                alertMessage += " Ushbu userga tegishli id ostida bo`sh o`rin yo`q!";
            }
            if (IDs[0] === false || IDs[1] === false) {
                alertMessage += " SHAXSIYda yoki REEGda ko`rsatilgan ID  topilmadi!";
                document.getElementById("offerID").style.borderColor  = acceptBorderColor;
                document.getElementById("RegID").style.borderColor = acceptBorderColor;
            }
            alert(alertMessage + " Anketa xato to`ldirilgan!");
        }
    });
</script>
</html>



