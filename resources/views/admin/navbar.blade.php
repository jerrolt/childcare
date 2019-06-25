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
	                                
	                                <li>
	                                	<a href="{{ route('admin-facilities') }}">
		                                	Facilities
                                        </a>
	                                </li>
	                                
	                                
	                                
	                                @if(!empty($facilities))	                               
	                                <li class="dropdown-submenu">
	                                	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
		                                	Classrooms
                                        </a>
                                        <ul class="dropdown-menu">
	                                        @foreach($facilities as $f)
	                                        <li>
	                                        	<a href="/admin/classrooms/{{ $f->id }}">
		                                        	{{ $f->name }}
	                                        	</a>
	                                        </li>
	                                        @endforeach
                                        </ul>
	                                </li>
	                                @else
	                                <li>
	                                	<a href="/admin/classrooms">
		                                	Classrooms
                                        </a>
	                                </li>
	                                @endif
	                                
	                                
                                    <li>
	                                	<a href="{{ route('guardian-admin') }}">
		                                	Parents/Guardians
                                        </a>
	                                </li>
                                    
                                    
                                    <li>
	                                	<a href="{{ route('student-admin') }}">
		                                	Children/Students
                                        </a>
	                                </li>
                                    
                                    <li>
	                                	<a href="{{ route('admin-attendance-records') }}">
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