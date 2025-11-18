import { Component } from '@angular/core';
import { ProductCardComponent } from '../product.card.component/product.card.component';

@Component({
  selector: 'app-result-display-component',
  imports: [ProductCardComponent],
  templateUrl: './result.display.component.html',
  styleUrl: './result.display.component.scss',
})
export class ResultDisplayComponent {

}
