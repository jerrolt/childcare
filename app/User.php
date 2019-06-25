<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     
    protected $fillable = [
        'name', 'email', 'password',
    ];
	*/
	protected $fillable = [
        'firstname', 'lastname', 'mi', 'email', 'password','phone','account_number','status'
    ];	
	
	
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    

    /**    
     * Compares the user role with parameter $roles
     *
     * @param string|array $roles
     * @return boolean
     */
	public function authorizeRoles($roles)
	{
		if(is_array($roles))
		{
			return $this->hasAnyRole($roles) ?? abort(401,'unauthorized action');
		}
		
		return $this->hasRole($roles) ?? abort(401,'unauthorized action');
	}


    /**    
     * Checks user role for a role within roles array
     * 
     * @param array $roles
     * @return boolean
     */ 	 
	public function hasAnyRole($roles)
	{
		return null !== $this->roles()->whereIn('name', $roles)->first();
	}


    /**    
     * Compares user role to role
     * 
     * @param string $role
     * @return boolean
     */ 	 
	public function hasRole($role)
	{
		return null !== $this->roles()->where('name', $role)->first();
	}    
    
    
    public function roles()
	{
		return $this->belongsToMany(Role::class);
	}

	public function guardian()
	{
		return $this->hasOne(Guardian::class);	
	}
	
	public function timecard_changes()
    {
	    return $this->hasMany(TimecardChange::class);
    }
}
