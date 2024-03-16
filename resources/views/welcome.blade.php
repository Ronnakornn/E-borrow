<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>E-borrow</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <style>
            /* @import url('https://fonts.googleapis.com/css2?family=Prompt:wght@400&display=swap'); */

            @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@400&family=Roboto&display=swap');

            *{
                padding:0;
                margin:0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Mitr', sans-serif;
                color: #00154c;
            }

            .btn {
                /* padding: 20px 20px 20px 20px; */
                padding:20px 10px 20px 10px;
                font-family: 'Roboto',sans-serif;
                border-style: none;
                background-color: orange;
                color: 00154b;
                border-radius: 10px;
                width: 55px;
                box-shadow: 0 0 10px #ccc;
                text-align: center;
                justify-content: center;
                align-items: center;
            }

            .btn2 {
                /* padding:20px 20px 20px 20px; */

                border-style: none;
                background-color: #cccccc00;
                font-size: 16px;
                color: black;
                width: 70px;

            }

            #under-con ,#success {
                margin-top:1rem;
                width:50%;
                border-radius: 20px;
                box-shadow: 0 0 10px #ccc;
            }

            #container-img {
                display:flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                width:  100vw;
                height: 100px;

            }

            #container-success {
                display:none;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                text-align: center;
                width:100vw;
                margin:0 auto;
                padding-bottom: 1rem;


            }

            #container-success img {
                border-radius: 20px;
                box-shadow: 0 4px 10px #ccc;
            }


            #container-img h2 {
                margin:1rem;
            }
            @media screen and (max-width:720px) {
                #under-con,#success {
                    width:90%;
                    /* padding:1rem; */
                }
            }
        </style>


    </head>
    <body>
        <div class="main flex items-center justify-center">
            <div id="container-img">
                <img src="/images/pageLogin.png" alt="LMS" id="under-con" style="display: none;">
                <h2 id="under-text"></h2>
            </div>

            <div id="container-success" style="justify-content: center; align-items: center; text-align: center; display: flex;">
                <img src="/images/pageLogin.png" alt="LMS banner" id="success">
            </div>


            <!-- <h2 style="display:grid;justify-content: center;"></h2> -->
            <div style="display: grid;justify-content: between; align-items: center;">

                <div style="display: flex;justify-content: center; align-items: center;">

                    <p id="demo"><a href="https://e-borrow.com/user/login" style="margin-top:1rem;border-style:none;text-decoration:none;background-color:#00154b;padding:10px 20px;border-radius:20px;color:white;cursor:pointer;"> เข้าสู่ระบบ ยืมอุปกรณ์ </a></p>
                </div>



            </div>

    <div id="extwaiokist" style="display:none" v="fcoon" q="9d3ad46c" c="719.5" i="746" u="27.90" s="03142406" sg="svr_09102316-ga_03142406-bai_02292418" d="1" w="false" e="" a="2" m="BMe="><div id="extwaigglbit" style="display:none" v="fcoon" q="9d3ad46c" c="719.5" i="746" u="27.90" s="03142406" sg="svr_09102316-ga_03142406-bai_02292418" d="1" w="false" e="" a="2" m="BMe="></div></div></div></body>
</html>
