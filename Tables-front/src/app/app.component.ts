import { Component } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'tables';
  public data:any = [];
  constructor(private http: HttpClient) {

  };

  ngOnInit(): void {
    this.getData();
  }

  getData() {
    const url = 'http://localhost:8000/sendjson/?archived=false&page=1&size=10000';
    this.http.get(url).subscribe((res) => {
      this.data = res;
      console.log(JSON.stringify(this.data, null, 2));
    });
  };
};
