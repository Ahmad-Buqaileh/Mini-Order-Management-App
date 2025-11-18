import { Component } from '@angular/core';
import { HeaderComponent } from '../../../../components/header.component/header.component';
import { OrderItemCardComponent } from '../../components/order.item.card.component/order.item.card.component';

@Component({
  selector: 'app-order.info.page',
  imports: [OrderItemCardComponent, HeaderComponent],
  templateUrl: './order.info.page.html',
  styleUrl: './order.info.page.scss',
})
export class OrderInfoPage {

}
