                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                                    ({{ ucfirst(Auth::user()->roles->first()->name) }}) <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu multi-level">
	                                
	                                
	                                <li>
	                                	<a href="{{ route('home') }}">
		                                	Home/Dashboard
                                        </a>
	                                </li>
	                                
	                                <!--
	                                <li>
	                                	<a href="#">
		                                	My Profile
                                        </a>
	                                </li>
	                                 -->                          
                                    
                                    <li>
	                                	<a href="{{ route('guardian-students') }}">
		                                	Children/Students
                                        </a>
	                                </li>
                                    
                                    <li>
	                                	<a href="{{ route('attendance-records') }}">
		                                	Attendance Records
                                        </a>
	                                </li>
                                    
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>