<link rel="preconnect" href="https://fonts.gstatic.com" />
<!-- External CSS libraries -->
<link rel="stylesheet" type="text/css" href="{{asset('website/css/bootstrap.min.css')}}"  async defer>
<link rel='stylesheet' id='mvp-style-css'  href="{{asset('website/css/menustyle.min.css')}}" type='text/css' media='all' async defer/>
<!-- <link crossorigin="anonymous" rel='stylesheet' id='mvp-fonts-css' href='//fonts.googleapis.com/css?family=Oswald%3A400%2C700%7CLato%3A400%2C700%7CWork+Sans%3A900%7CMontserrat%3A400%2C700%7COpen+Sans%3A800%7CPlayfair+Display%3A400%2C700%2C900%7CQuicksand%7CRaleway%3A200%2C400%2C700%7CRoboto+Slab%3A400%2C700%7CWork+Sans%3A100%2C200%2C300%2C400%2C500%2C600%2C700%2C800%2C900%7CMontserrat%3A100%2C200%2C300%2C400%2C500%2C600%2C700%2C800%2C900%7CWork+Sans%3A100%2C200%2C300%2C400%2C500%2C600%2C700%2C800%2C900%7CLato%3A100%2C200%2C300%2C400%2C500%2C600%2C700%2C800%2C900%7CMontserrat%3A100%2C200%2C300%2C400%2C500%2C600%2C700%2C800%2C900%26subset%3Dlatin%2Clatin-ext%2Ccyrillic%2Ccyrillic-ext%2Cgreek-ext%2Cgreek%2Cvietnamese&display=swap'type='text/css' media='all'/> -->
<link rel="stylesheet" type="text/css" href="{{asset('plugins/fontawesome-pro-5.12.0/css/all.min.css')}}" async defer>
<link rel="stylesheet" type="text/css" href="{{asset('website/css/slick.min.css')}}" async defer>
<link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}" async defer>
<!-- Favicon icon -->
<link rel="shortcut icon" href="{{asset('favicon.ico')}}" type="image/x-icon">

<link rel="stylesheet" type="text/css" href="{{asset('website/fonts/font-awesome/css/font-awesome.min.css')}}" async defer>

<!-- Google fonts -->
<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet" async defer>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,700" rel="stylesheet" async defer>

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<!--[if eq IE 10]><link rel="stylesheet" type="text/css" href="{{ asset('website/css/ie10-viewport-bug-workaround.css')}}"><![endif]-->

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="{{asset('website/js/html5shiv.min.js')}}"></script>
<script src="{{asset('website/js/respond.min.js')}}"></script>
<![endif]-->

@yield('css_library')

<!-- Custom stylesheet -->
<link rel="stylesheet" type="text/css" href="{{asset('website/css/style.min.css')}}" async defer>
<link rel="stylesheet" type="text/css" href="{{asset('website/css/skins/default.css')}}" id="style_sheet" async defer>


@yield('css')
