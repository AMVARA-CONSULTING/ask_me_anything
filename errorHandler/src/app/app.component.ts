import { HttpErrorResponse } from '@angular/common/http';
import { Component } from '@angular/core';
import { ApiService } from './services/api.service';
import { setErroCodeMessage } from './custumSelectors/errors.selector';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {
  title = 'errorHandler';

  constructor(private api: ApiService) {}
  
  fire404() {
    this.api.get404().subscribe({
      next: (res) => {},
      error: (err) => {
        setErroCodeMessage(err.status, "emitted by AppComponent/ngOnInit - line: 20")
        throw new HttpErrorResponse(err);
      }
    });
  }

  fire401() {
    this.api.get401().subscribe({
      next: (res) => {},
      error: (err) => {
        setErroCodeMessage(err.status, "emitted by AppComponent/ngOnInit - line: 30")
        throw new HttpErrorResponse(err);
      }
    });
  }
}
