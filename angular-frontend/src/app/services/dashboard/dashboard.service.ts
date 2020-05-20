import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {environment} from '../../../environments/environment';
import {DashboardStatisticsResponseModel} from '../../models/Response/dashboard-statistics-response.model';
import {Observable} from 'rxjs';

const API_URL = environment.apiUrl;

@Injectable({
  providedIn: 'root'
})
export class DashboardService {

  constructor(private http: HttpClient) {
  }

  getStatistics(): Observable<DashboardStatisticsResponseModel> {
    return this.http.get<DashboardStatisticsResponseModel>(API_URL + '/api/dashboard/statistics');
  }
}
