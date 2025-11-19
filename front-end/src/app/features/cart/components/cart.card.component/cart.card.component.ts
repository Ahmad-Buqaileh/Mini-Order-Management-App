import { Component, Input } from '@angular/core';
import { CommonModule } from '@angular/common';
import { CartItemResponse } from '../../services/cart.service';

@Component({
  selector: 'app-cart-card-component',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './cart.card.component.html',
  styleUrls: ['./cart.card.component.scss'],
})
export class CartCardComponent {
  @Input() cartItem!: CartItemResponse;
}
