import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from '../../../../environments/environment';

export interface CartItemResponse {
  id: string;
  quantity: number;
  subtotal: number;
  product: {
    name: string;
    price: number;
  };
}

@Injectable({
  providedIn: 'root',
})
export class CartService {
  private api = environment.cartUrl;

  constructor(private http: HttpClient) {}

  getCartItems(userId: string) {
    return this.http.get<CartItemResponse[]>(`${this.api}/cart/${userId}`);
  }

  createUserCart(userId: string) {
    return this.http.post<{ message: string }>(`${this.api}/`, { userId });
  }
}
