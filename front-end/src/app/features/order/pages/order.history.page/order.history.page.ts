import { Component } from '@angular/core';
import { HeaderComponent } from '../../../../components/header.component/header.component';
import { OrderCardComponent } from '../../components/order.card.component/order.card.component';

@Component({
  selector: 'app-order.history.page',
  imports: [HeaderComponent, OrderCardComponent],
  templateUrl: './order.history.page.html',
  styleUrl: './order.history.page.scss',
})
export class OrderHistoryPage {}
