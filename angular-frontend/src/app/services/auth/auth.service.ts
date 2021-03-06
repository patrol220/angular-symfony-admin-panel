import {Injectable} from '@angular/core';
import {HttpClient, HttpHeaders} from '@angular/common/http';
import {Observable} from 'rxjs';
import {environment} from '../../../environments/environment';

const API_URL = environment.apiUrl;

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  constructor(private http: HttpClient) {
  }

  login(loginCredentials: any): Observable<any> {

    const options = {
      headers: new HttpHeaders({'Content-Type': 'application/json'}),
      withCredentials: true,
      observe: 'response' as 'response'
    };

    return this.http.post(API_URL + '/api/login_check', loginCredentials, options);
  }

  logout(): Observable<any> {
    return this.http.post(API_URL + '/api/logout', {});
  }

  isUserLogged() {
    return localStorage.getItem('userLoggedIn') === 'true';
  }

  setUserLogged() {
    localStorage.setItem('userLoggedIn', 'true');
  }

  unsetUserLogged() {
    localStorage.removeItem('userLoggedIn');
  }
}
