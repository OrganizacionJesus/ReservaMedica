<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect('/login');
        }
        
        $roles = explode('|', $role);
        $userRole = $this->getUserRole($user);
        
        if (!in_array($userRole, $roles)) {
            abort(403, 'No tiene permisos para acceder a esta página.');
        }
        
        return $next($request);
    }
    
    private function getUserRole($user)
    {
        // Mapeo directo desde rol_id (más confiable que relaciones)
        $roleMap = [
            1 => 'admin',
            2 => 'medico',
            3 => 'paciente'
        ];
        
        return $roleMap[$user->rol_id] ?? 'guest';
    }
}
