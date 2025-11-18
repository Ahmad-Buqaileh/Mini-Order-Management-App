import { Component } from '@angular/core';
import { ProductCardComponent } from '../product.card.component/product.card.component';

@Component({
  selector: 'app-display-component',
  imports: [ProductCardComponent],
  templateUrl: './display.component.html',
  styleUrl: './display.component.scss',
})
export class DisplayComponent {}
