import {HttpErrorResponse, HttpEvent, HttpHandler, HttpInterceptor, HttpRequest} from '@angular/common/http';
import {Observable, throwError} from 'rxjs';
import {catchError} from 'rxjs/operators';
import {UNAUTHORIZED} from 'http-status-codes';
import {Router} from '@angular/router';
import {Injectable} from '@angular/core';
import {NotificationsService} from 'angular2-notifications';
import {AuthService} from '../services/auth/auth.service';

@Injectable()
export class ErrorInterceptor implements HttpInterceptor {
  constructor(
    private router: Router,
    private notificationsService: NotificationsService,
    private authService: AuthService
  ) {
  }

  intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    return next.handle(req)
      .pipe(
        catchError((error: HttpErrorResponse) => {
          if (error.status === UNAUTHORIZED) {
            this.authService.unsetUserLogged();
            this.router.navigate(['login']);
          }
          this.notificationsService.error('Error occurred', error.error.message);
          return throwError(error);
        })
      );
  }
}
