import { Component } from '@angular/core';
import { RouterLink } from '@angular/router';
import { Input } from '@angular/core';
@Component({
  selector: 'app-order-card-component',
  imports: [RouterLink],
  templateUrl: './order.card.component.html',
  styleUrl: './order.card.component.scss',
})
export class OrderCardComponent {
  @Input() order!: any;


}
