import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { AddProductModel } from '../components/model/product.model';
import { environment } from '../../../../environments/environment';

export interface ProductResponse {
  id: string;
  name: string;
  category: string;
  price: number;
  stock: number;
}

@Injectable({
  providedIn: 'root',
})
export class ProductService {
  private productApi = environment.productUrl;
  private cartItemApi = environment.cartItemUrl;

  constructor(private http: HttpClient) {}

  getProducts() {
    return this.http.get<ProductResponse[]>(this.productApi);
  }
  
  addProductToCart(product: AddProductModel) {
    return this.http.post(this.cartItemApi, product);
  }
}
