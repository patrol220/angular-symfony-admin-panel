import {Component, OnInit} from '@angular/core';
import {FormBuilder} from '@angular/forms';
import {AuthService} from '../../services/auth/auth.service';
import {catchError, finalize} from 'rxjs/operators';
import {HttpErrorResponse} from '@angular/common/http';
import {Notification, throwError} from 'rxjs';
import {Router} from '@angular/router';
import {NotificationsService} from 'angular2-notifications';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {
  loginForm;
  isRequestProcessing = false;

  constructor(
    private formBuilder: FormBuilder,
    private authService: AuthService,
    private router: Router,
    private notificationsService: NotificationsService
  ) {
    this.loginForm = this.formBuilder.group({
      username: '',
      password: ''
    });
  }

  ngOnInit(): void {
  }

  onSubmit(loginCredentials) {
    this.isRequestProcessing = true;
    this.authService.login(loginCredentials)
      .pipe(
        catchError((error: HttpErrorResponse) => {
          return throwError(error);
        }),
        finalize(() => {
          this.isRequestProcessing = false;
        })
      )
      .subscribe(
        (data) => {
          this.notificationsService.success('Logged in', 'Successfully logged in!');
          this.router.navigate(['admin-panel']);
          this.authService.setUserLogged();
        });
  }

}
