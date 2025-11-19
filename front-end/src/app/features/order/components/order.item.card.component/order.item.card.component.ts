import { Component, Input } from '@angular/core';

@Component({
  selector: 'app-order-item-card-component',
  imports: [],
  templateUrl: './order.item.card.component.html',
  styleUrl: './order.item.card.component.scss',
})
export class OrderItemCardComponent {
  @Input() orderItem!: any;
}
