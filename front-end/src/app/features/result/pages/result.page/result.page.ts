import { Component } from '@angular/core';
import { HeaderComponent } from '../../../../components/header.component/header.component';
import { ResultDisplayComponent } from '../../components/result.display.component/result.display.component';

@Component({
  selector: 'app-result.page',
  imports: [HeaderComponent,ResultDisplayComponent],
  templateUrl: './result.page.html',
  styleUrls: ['./result.page.scss'],
})
export class ResultPage {

}
