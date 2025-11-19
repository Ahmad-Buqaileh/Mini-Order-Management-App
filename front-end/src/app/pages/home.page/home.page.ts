import { Component } from '@angular/core';
import { HeaderComponent } from '../../components/header.component/header.component';
import { SearchComponent } from '../../features/search/components/search.component/search.component';
import { CategoryComponent } from '../../features/search/components/category.component/category.component';
import { DisplayComponent } from '../../features/result/components/display.component/display.component';

@Component({
  selector: 'app-home-page',
  standalone: true,
  imports: [HeaderComponent, SearchComponent, CategoryComponent, DisplayComponent],
  templateUrl: './home.page.html',
  styleUrl: './home.page.scss',
})
export class HomePage {}
