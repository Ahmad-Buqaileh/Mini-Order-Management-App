import { Injectable } from '@angular/core';
import { environment } from '../../../../environments/environment';
import { HttpClient } from '@angular/common/http';
import { map } from 'rxjs/operators';
import { response } from 'express';

export interface OrderResponse {
  id: string;
  total: number;
  createdAt: Date;
}

interface OrderApiResponse {
  success: boolean;
  orders: any[];
}

interface OrderItemsApiResponse {
  success: boolean;
  OrderItems: OrderItemsResponse[]; 
}

export interface OrderItemsResponse {
  id: string;
  productName: string;
  quantity: number;
  price: string;
  subtotal: string;
}

@Injectable({
  providedIn: 'root',
})
export class OrderService {
  private api = environment.orderUrl;

  constructor(private http: HttpClient) {}

  getOrderItems(orderId: string) {
    return this.http.get<OrderItemsApiResponse>(`${this.api}/order/${orderId}`).pipe(
      map((response) => response.OrderItems)
    )
  }
  getOrderHistory(userToken: string) {
    return this.http.get<OrderApiResponse>(`${this.api}/${userToken}`).pipe(
      map((response) =>
        response.orders.map((order) => ({
          ...order,
          createdAt: new Date(order.createdAt.date.replace(' ', 'T')),
        }))
      )
    );
  }
  createOrder(userToken: string) {
    return this.http.post<OrderResponse>(`${this.api}/${userToken}`, {});
  }
}
