import {Injectable} from '@angular/core';
import {
  HttpRequest,
  HttpHandler,
  HttpEvent,
  HttpInterceptor, HttpHeaders
} from '@angular/common/http';
import {Observable} from 'rxjs';

@Injectable()
export class RequestInterceptor implements HttpInterceptor {

  constructor() {
  }

  intercept(request: HttpRequest<unknown>, next: HttpHandler): Observable<HttpEvent<unknown>> {

    const requestProperties: any = {};

    if (request.headers.get('Content-Type') === null) {
      requestProperties.setHeaders = {'Content-Type': 'application/json'};
    }

    requestProperties.withCredentials = true;

    const modifiedRequest = request.clone({
      withCredentials: true
    });

    console.log(modifiedRequest);

    return next.handle(modifiedRequest);
  }
}
