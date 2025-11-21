import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { RegisterModel } from '../models/register.model';
import { environment } from '../../../../environments/environment';
import { LoginModel } from '../models/login.model';

export interface AuthResponse {
  success: boolean;
  message: string;
  accessToken: string;
}

@Injectable({ providedIn: 'root' })
export class AuthService {
  private api = environment.authUrl;

  constructor(private http: HttpClient) {}

  register(data: RegisterModel) {
    return this.http.post<AuthResponse>(`${this.api}/register`, data, { withCredentials: true });
  }

  login(data: LoginModel) {
    return this.http.post<AuthResponse>(`${this.api}/login`, data, { withCredentials: true });
  }

  logout() {
    return this.http.get<{ success: boolean; message: string }>(`${this.api}/logout`, {
      withCredentials: true,
    });
  }

  refreshToken() {
    return this.http.get<AuthResponse>(`${this.api}/refresh`, { withCredentials: true });
  }
}
