import {AfterViewInit, Component, OnInit, ViewChild} from '@angular/core';
import {Router} from '@angular/router';
import {AuthService} from './services/auth/auth.service';
import {MatSidenav} from '@angular/material/sidenav';
import {SidenavService} from './services/sidenav/sidenav.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent implements AfterViewInit {
  title = 'angular-frontend';

  @ViewChild('sidenav') public sidenav: MatSidenav;

  constructor(private sidenavService: SidenavService) {
  }

  ngAfterViewInit() {
    this.sidenavService.setSidenav(this.sidenav);
  }
}
