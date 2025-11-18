import { Component } from '@angular/core';
import { HeaderComponent } from '../../components/header.component/header.component'; 

@Component({
  selector: 'app-home-page',
  standalone: true,
  imports: [HeaderComponent],
  templateUrl: './home.page.html',
  styleUrl: './home.page.scss',
})
export class HomePage {

}
