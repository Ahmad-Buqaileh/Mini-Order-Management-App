import { Component } from '@angular/core';
import { HeaderComponent } from '../../../../components/header.component/header.component';
import { CartCardComponent } from '../../components/cart.card.component/cart.card.component';

@Component({
  selector: 'app-cart.page',
  imports: [HeaderComponent,CartCardComponent],
  templateUrl: './cart.page.html',
  styleUrl: './cart.page.scss',
})
export class CartPage {

}
