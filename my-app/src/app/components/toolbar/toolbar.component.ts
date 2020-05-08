import {Component, OnInit} from '@angular/core';
import {AuthService} from '../../services/auth/auth.service';
import {Router} from '@angular/router';
import {NotificationsService} from 'angular2-notifications';
import {SidenavService} from '../../services/sidenav/sidenav.service';

@Component({
  selector: 'app-toolbar',
  templateUrl: './toolbar.component.html',
  styleUrls: ['./toolbar.component.scss']
})
export class ToolbarComponent implements OnInit {

  constructor(
    private authService: AuthService,
    private router: Router,
    private notificationsService: NotificationsService,
    private sidenavService: SidenavService
  ) {
  }

  ngOnInit(): void {
  }

  logout() {
    this.authService.logout().subscribe(() => {
      this.notificationsService.success('Logout', 'Successfully logged out!');
      this.router.navigate(['login']);
      this.authService.unsetUserLogged();
    });
  }

  isVisible(): boolean {
    return this.router.url.includes('/admin-panel');
  }

  settings() {
    console.log(this.router.url);
  }

  openSidenav() {
    this.sidenavService.open();
  }
}
