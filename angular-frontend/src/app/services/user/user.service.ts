import {Injectable} from '@angular/core';
import {HttpClient, HttpParams} from '@angular/common/http';
import {environment} from '../../../environments/environment';
import {Observable} from 'rxjs';
import {UserApiModel} from '../../models/Api/user-api.model';

const API_URL = environment.apiUrl;

@Injectable({
  providedIn: 'root'
})
export class UserService {

  constructor(private http: HttpClient) {
  }

  getCurrentlyLoggedUser(includes: Array<string> = []): Observable<UserApiModel> {

    let httpParams = new HttpParams();

    includes.forEach((include) => {
      httpParams = httpParams.append('include', include);
    });

    const options = {
      params: httpParams
    };

    return this.http.get<UserApiModel>(API_URL + '/api/user', options);
  }

  updateCurrentlyLoggedUser(user: UserApiModel) {
    return this.http.patch(API_URL + '/api/user', user);
  }
}
