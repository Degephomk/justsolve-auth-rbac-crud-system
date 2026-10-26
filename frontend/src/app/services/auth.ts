import { Injectable, inject } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';
import { tap } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  private http = inject(HttpClient);
  private router = inject(Router);

  private api = 'http://localhost:8001/api'; // Laravel API base URL

  /**
   * Register a new user.
   */
  register(data: any) {
    return this.http.post(`${this.api}/register`, data);
  }

  /**
   * Login a user and store JWT + user data.
   */
  login(data: any) {
    return this.http.post<any>(`${this.api}/login`, data).pipe(
      tap(res => {
        if (res?.token) {
          localStorage.setItem('token', res.token);
        }
        if (res?.user) {
          localStorage.setItem('user', JSON.stringify(res.user));
        }
      })
    );
  }

  /**
   * Logout user (invalidate token in backend + clear local storage)
   */
  logout() {
    return this.http.post(`${this.api}/logout`, {}).pipe(
      tap(() => {
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        this.router.navigate(['/login']);
      })
    );
  }

  /**
   * Get currently logged-in user from localStorage
   */
  getUser() {
    try {
      const raw = localStorage.getItem('user');
      return raw ? JSON.parse(raw) : null;
    } catch {
      return null;
    }
  }

  /**
   * Quick boolean check
   */
  isLoggedIn(): boolean {
    return !!localStorage.getItem('token');
  }

  /**
   * Get token for HTTP interceptor
   */
  getToken(): string | null {
    return localStorage.getItem('token');
  }

  /**
   * Check if logged-in user is admin
   */
  isAdmin(): boolean {
    const user = this.getUser();
    return user?.role === 'admin';
  }
}
