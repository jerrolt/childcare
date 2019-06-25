@extends('layouts.identify')

@section('content')
    <div id="Container">
	    <!--
        <nav class="navbar navbar-inverse">
          <div class="container-fluid">
            <div class="navbar-header">
              <div class="navbar-brand" href="#" style="color: white;">Fingerprint WebAPI</div>
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
        -->
       <div id="c-reader">
	       <h4>Select Reader :</h4>
            <select class="form-control" id="readersDropDown" onchange="selectChangeEvent()">
            </select>
       </div>
       <div id="Scores" class="text-left" style="border:none;">
           <h5>
	           Scan Quality: <span id="qualityInputBox"></span>
	       </h5>
           <!--
           <input type="text" id="qualityInputBox" size="20" style="background-color:#DCDCDC;text-align:center;"> 
		   -->
       </div>
        <div id="content-capture" style="display : none;">    
            <div id="status"></div>            
            <div id="imagediv"></div>
            <div id="contentButtons">
                <table width=70% align="center">
                    <tr>
                        <td>
                            <input type="button" class="btn btn-primary" id="clearButton" value="Clear" onclick="Javascript:onClear()">
                        </td>
                        <td data-toggle="tooltip" title="Will work with the .png format.">
                            <input type="button" class="btn btn-primary" id="save" value="Save">
                        </td>
                        <td>
                            <input type="button" class="btn btn-primary" id="start" value="Start" onclick="Javascript:onStart()">
                        </td>
                        <td>
                           <input type="button" class="btn btn-primary" id="stop" value="Stop" onclick="Javascript:onStop()">
                        </td>
                        <td>
                            <input type="button" class="btn btn-primary" id="info" value="Info" onclick="Javascript:onGetInfo()">
                        </td>
                </table>
            </div>
       
            <div id="imageGallery">
            </div>
            <div id="deviceInfo">           
            </div>

            <div id="saveAndFormats">
             
              <form name="myForm" style ="border : solid grey;padding:5px;">
              <b>Acquire Formats :</b><br>
              <table>
                <tr data-toggle="tooltip" title="Will save data to a .raw file.">
                  <td>
                    <input type="checkbox" name="Raw" value="1" onclick="checkOnly(this)"> RAW  <br>
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
              <input type="checkbox" name="PngImage" checked="true" value="4" onclick="checkOnly(this)"> PNG
                  </td>
                </tr>
              </table>
              </form>
              <!--
              <br>
             <input type="button" class="btn btn-primary" id="saveImagePng" value="Export" onclick="Javascript:onImageDownload()">
             -->
             <br/>
             <input type="button" class="btn btn-primary" id="saveImagePng" value="Continue" onclick="Javascript:onLogin()">
            </div>

        </div>


		
		
		<!--
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

              
              <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">
                
                  
                  <div class="modal-content" id="modalContent" >
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
  
            </div>
        </div>
		-->



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
@endsection