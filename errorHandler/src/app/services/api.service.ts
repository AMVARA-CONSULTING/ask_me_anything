import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { catchError, Observable, throwError } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ApiService {

  constructor(private http: HttpClient) {
  }

  get401(): Observable<any> {
    return this.http.get<any>("https://git.amvara.de/api/v4/version");
  }
  get404(): Observable<any> {
    return this.http.get<any>("assets/test.json")
  }
}
