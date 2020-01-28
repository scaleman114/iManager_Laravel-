<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Weigh-Till Manager Contracts</title>
    <!---*** Start: Bootstrap 3.3.7 version files. ***--->
    <script language="javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">
    </script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!---*** End: Bootstrap 3.3.7 version files. ***--->



    <style>
    /** Define the margins of your page **/
    @page {
        margin: 100px 25px;
    }

    .logo {
        position: absolute;

        top: -80px;
        left: 0px;

    }

    .signaturestrip {
        position: absolute;

        bottom: -60px;
        left: 20px;
        right: 0px;
        height: 100px;

    }

    header {

        top: -70px;
        left: 0px;
        right: 0px;
        height: 40px;

        /** Extra personal styles **/
        background-color: #03a9f4;
        color: white;
        text-align: center;
        line-height: 30px;

        /**font style **/
        font-size: 15px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
    }

    footer {
        position: fixed;
        bottom: -70px;
        left: 0px;
        right: 0px;
        height: 40px;

        /** Extra personal styles **/
        background-color: #03a9f4;
        color: white;
        text-align: center;
        line-height: 30px;
    }

    .thead-inverse th {
        color: #fff;
        background-color: #373a3c;
    }

    .thead-light th {
        color: #000;
        background-color: #D3D3D3;
    }

    .thead-lightw th {
        color: #fff;
        background-color: #D3D3D3;
        font-size: .8rem;

    }

    /** Means top & bottom 15px, right & left 10px **/
    .gap {
        margin: 15px 10px;
    }
    </style>












</head>

<body>
    <div class="logo">
        <img src="img/wt_logo_2019.png" width="25%" height="25%" />
    </div>

    <div class="gap">
        <header>

            Weigh-Till Contract Visit Sheet

        </header>
    </div>

    <div class="container-fluid">
        @yield('content')
    </div>
    <div class="gap">
        <footer>
            <p>Weigh-Till - Sparkenhoe House - Southfield Rd - Hinckley - LE10 1UB - Tel.: 01455 617227
            </p>

        </footer>
    </div>



</body>

</html>
