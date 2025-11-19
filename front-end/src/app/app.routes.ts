import { Routes } from '@angular/router';

export const routes: Routes = [
  {
    path: '',
    pathMatch: 'full',
    loadComponent: () => {
      return import('./pages/home.page/home.page').then((m) => m.HomePage);
    },
  },
  {
    path: 'auth',
    loadComponent: () => {
      return import('./features/auth/pages/auth.page/auth.page').then((m) => m.AuthPage);
    },
  },
  {
    path: 'cart',
    loadComponent: () => {
      return import('./features/cart/pages/cart.page/cart.page').then((m) => m.CartPage);
    },
  },
  {
    path: 'results/:query',
    loadComponent: () => {
      return import('./features/result/pages/result.page/result.page').then((m) => m.ResultPage);
    },
  },
  {
    path: 'order-history',
    loadComponent: () => {
      return import('./features/order/pages/order.history.page/order.history.page').then(
        (m) => m.OrderHistoryPage
      );
    },
  },
  {
    path: 'order-info/:orderId',
    loadComponent: () => {
      return import('./features/order/pages/order.info.page/order.info.page').then(
        (m) => m.OrderInfoPage
      );
    },
  },
];
