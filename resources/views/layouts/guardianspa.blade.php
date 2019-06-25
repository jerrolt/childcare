<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/scanfp/css/bootstrap-min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/scanfp/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
.dropdown-submenu {
    position: relative;
}

.dropdown-submenu>.dropdown-menu {
    top: 0;
    left: 100%;
    margin-top: -6px;
    margin-left: -1px;
    -webkit-border-radius: 0 6px 6px 6px;
    -moz-border-radius: 0 6px 6px;
    border-radius: 0 6px 6px 6px;
}

.dropdown-submenu:hover>.dropdown-menu {
    display: block;
}

.dropdown-submenu>a:after {
    display: block;
    content: " ";
    float: right;
    width: 0;
    height: 0;
    border-color: transparent;
    border-style: solid;
    border-width: 5px 0 5px 5px;
    border-left-color: #ccc;
    margin-top: 5px;
    margin-right: -10px;
}

.dropdown-submenu:hover>a:after {
    border-left-color: #fff;
}

.dropdown-submenu.pull-left {
    float: none;
}

.dropdown-submenu.pull-left>.dropdown-menu {
    left: -100%;
    margin-left: 10px;
    -webkit-border-radius: 6px 0 6px 6px;
    -moz-border-radius: 6px 0 6px 6px;
    border-radius: 6px 0 6px 6px;
}


			.rotate-90 {
			  -moz-transform: rotate(90deg);
			  -webkit-transform: rotate(90deg);
			  -o-transform: rotate(90deg);
			  transform: rotate(90deg);
			}
			
			.rotate-180 {
			  -moz-transform: rotate(180deg);
			  -webkit-transform: rotate(180deg);
			  -o-transform: rotate(180deg);
			  transform: rotate(180deg);
			}
			
			.rotate-270 {
			  -moz-transform: rotate(270deg);
			  -webkit-transform: rotate(270deg);
			  -o-transform: rotate(270deg);
			  transform: rotate(270deg);
			}
			
			.flip {
			  -moz-transform: scaleX(-1);
			  -webkit-transform: scaleX(-1);
			  -o-transform: scaleX(-1);
			  transform: scaleX(-1);
			}
			
			.flip-and-rotate-90 {
			  -moz-transform: rotate(90deg) scaleX(-1);
			  -webkit-transform: rotate(90deg) scaleX(-1);
			  -o-transform: rotate(90deg) scaleX(-1);
			  transform: rotate(90deg) scaleX(-1);
			}
			
			.flip-and-rotate-180 {
			  -moz-transform: rotate(180deg) scaleX(-1);
			  -webkit-transform: rotate(180deg) scaleX(-1);
			  -o-transform: rotate(180deg) scaleX(-1);
			  transform: rotate(180deg) scaleX(-1);
			}
			
			.flip-and-rotate-270 {
			  -moz-transform: rotate(270deg) scaleX(-1);
			  -webkit-transform: rotate(270deg) scaleX(-1);
			  -o-transform: rotate(270deg) scaleX(-1);
			  transform: rotate(270deg) scaleX(-1);
			}
	</style>
	
</head>
<body>
    <div id="app">
	    
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-left">
                        <!-- Authentication Links -->
                        @guest
                        	<li><a href="{{ route('fingerprint-login') }}">Fingerprint Login</a></li>
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            @includeIf($nav, ['facilities' => (isset($facilities) ? $facilities : [])])
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        
        
        
        
        
        
        
    <div id="Container">
	    
	    
        <nav class="navbar navbar-inverse">
          <div class="container-fluid">
            <div class="navbar-header">
              <div class="navbar-brand" href="#" style="color: white;">Fingerprint Login</div>
            </div>
            <ul class="nav navbar-nav">
              <li id="Reader" class="active">
                <a href="#" style="color: white;" onclick="toggle_visibility(['content-reader','content-capture']);setActive('Reader','Capture')">
                    Reader</a>
              </li>
            </ul>
            <ul class="nav navbar-nav">
              <li id="Capture" class="">
                <a href="#" style="color: white;" onclick="toggle_visibility(['content-capture','content-reader']);setActive('Capture','Reader')">
                    Capture</a>
              </li>
            </ul>                       
          </div>
        </nav>
        
        
        
       <div id="Scores">
           <h5>Scan Quality : <input type="text" id="qualityInputBox" size="20" style="background-color:#DCDCDC;text-align:center;"></h5>
       </div>
       
       
       
       
       
        <div id="content-capture" style="display : none;">    
            <div id="status"></div>            
            
            <div id="contentButtons">
                <table width=70% align="center">
                    <tr>
                        <td>
                            <input type="button" class="btn btn-primary" id="clearButton" value="Clear" onclick="Javascript:onClear()">
                        </td>
                        <td data-toggle="tooltip" title="Will work with the .png format.">
                            <input  type="button" style="display: none;" class="btn btn-primary" id="save" value="Save">
                        </td>
                        <td>
                            <input type="button" class="btn btn-primary" id="start" value="Start" onclick="Javascript:onStart()">
                        </td>
                        <td>
                           <input style="display: none;" type="button" class="btn btn-primary" id="stop" value="Stop" onclick="Javascript:onStop()">
                        </td>
                        <td>
                            
                            
                            <input type="button" class="btn btn-primary" id="saveImagePng" value="Login" onclick="Javascript:onLogin()">
                        </td>
                </table>
            </div>
       
       
			<div id="imagediv"></div>
       
       
            <div id="imageGallery">
            </div>
            
            <div id="deviceInfo">           
            </div>




            <div id="saveAndFormats" style="opacity: 0;">             
              <form name="myForm" style ="border : solid grey;padding:5px;">
              <b>Acquired Formats :</b><br>
              <table>
                <tr data-toggle="tooltip" title="Will save data to a .raw file.">
                  <td>
                    <input type="checkbox" name="Raw" checked="true" value="1" onclick="checkOnly(this)"> RAW  <br>
                  </td>
                </tr>
                <tr data-toggle="tooltip" title="Will save data to a Intermediate file">
                  <td>
              <input type="checkbox" name="Intermediate" value="2" onclick="checkOnly(this)"> Feature Set<br>
                  </td>
                </tr>
                <tr data-toggle="tooltip" title="Will save data to a .wsq file.">
                  <td>
              <input type="checkbox" name="Compressed" value="3" onclick="checkOnly(this)"> WSQ<br>
                  </td>
                </tr>
                <tr data-toggle="tooltip" title="Will save data to a .png file.">
                  <td>
              <input type="checkbox" name="PngImage" value="4" onclick="checkOnly(this)"> PNG
                  </td>
                </tr>
              </table>
              </form>
            </div>

        </div><!-- END content-capture -->




        <div id="content-reader">  
            <h4>Select Reader :</h4>
            <select class="form-control" id="readersDropDown" onchange="selectChangeEvent()">
            </select>
            <div id="readerDivButtons">
                <table width=70% align="center">
                        <tr>
                            <td>
                                <input type="button" class="btn btn-primary" id="refreshList" value="Refresh List" 
                                    onclick="Javascript:readersDropDownPopulate(false)">
                            </td>
                            <td>
                                <input type="button" class="btn btn-primary" id="capabilities" value="Capabilities"
                                data-toggle="modal" data-target="#myModal" onclick="Javascript:populatePopUpModal()">
                            </td>  
                        </tr>
                </table>

              <!-- Modal - Pop Up window content-->
              <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">
                
                  <!-- Modal content -->
                  <div class="modal-content" id="modalContent">
	                  
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Reader Information</h4>
                    </div>
                    
                    <div class="modal-body" id="ReaderInformationFromDropDown">                     
                    </div>
                    
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                                       
                  </div>
                </div>
              </div>
  
            </div><!-- readerDivButtons -->
        </div>





<!-- POPUP MODAL IFRAME -->
			<div class="modal fade" tabindex="-1" role="dialog" id="fpcheckinModal" >
			  <div class="modal-dialog" role="document" style="min-width:1000px;">
				
      			
			    <div class="modal-content" >
				  <div class="modal-header">
				  	<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.reload();">
				  		<span aria-hidden="true" style="font-size:30px;font-style:normal;">&times;</span>
				  	</button>
      			  </div>		
			      <div class="modal-body">
			        <iframe id="fpcheckinFrame" name="fpscanner" frameborder="0" src="#" style="min-width:99%;min-height:400px;">
			        	<p>Your browser does not support iframes.</p>
					</iframe>
			      </div>			      
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="window.location.reload();">Close</button>
			      </div>
			    </div>
			    
			  </div>
			</div>
<!-- END POPUP MODAL IFRAME -->




</div>

	<script src="{{ asset('js/scanfp/lib/jquery.min.js') }}"></script>
    <script src="{{ asset('js/scanfp/lib/bootstrap.min.js') }}"></script> 
    <script src="{{ asset('js/scanfp/scripts/es6-shim.js') }}"></script>
    <script src="{{ asset('js/scanfp/scripts/websdk.client.bundle.min.js') }}"></script>
    <script src="{{ asset('js/scanfp/scripts/fingerprint.sdk.min.js') }}"></script>
    <script src="{{ asset('js/scanfp/app.js') }}"></script>       
</body>
</html>