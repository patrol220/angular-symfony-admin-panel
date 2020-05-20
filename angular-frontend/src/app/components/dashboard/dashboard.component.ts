import {Component, OnInit} from '@angular/core';
import {DashboardService} from '../../services/dashboard/dashboard.service';
import {DashboardStatisticsResponseModel} from '../../models/Response/dashboard-statistics-response.model';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.scss']
})
export class DashboardComponent implements OnInit {

  constructor(public dashboardService: DashboardService) {
  }

  statistics: DashboardStatisticsResponseModel;

  ngOnInit(): void {
    this.getStatistics();
  }

  getStatistics() {
    this.dashboardService.getStatistics().subscribe((responseData: DashboardStatisticsResponseModel) => {
      this.statistics = responseData;
    });
  }

}
