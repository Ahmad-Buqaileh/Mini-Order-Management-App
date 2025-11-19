import { Component, OnInit } from '@angular/core';
import { HeaderComponent } from '../../../../components/header.component/header.component';
import { ActivatedRoute } from '@angular/router';
import { Store } from '@ngrx/store';
import { AsyncPipe, CommonModule } from '@angular/common';
import { Observable } from 'rxjs';
import * as ResultActions from '../../../search/store/search.actions';
import { ProductResponse } from '../../../search/services/search.service';
import { selectSearchResults } from '../../../search/store/search.selectors';
import { ProductCardComponent } from '../../components/product.card.component/product.card.component';

@Component({
  selector: 'app-result.page',
  imports: [HeaderComponent, ProductCardComponent, AsyncPipe, CommonModule],
  standalone: true,
  templateUrl: './result.page.html',
  styleUrls: ['./result.page.scss'],
})
export class ResultPage implements OnInit {
  category: string | null = null;
  results$!: Observable<ProductResponse[]>;

  constructor(private route: ActivatedRoute, private store: Store) {}
  ngOnInit(): void {
    this.category = this.route.snapshot.paramMap.get('query');
    const source = this.route.snapshot.queryParamMap.get('source');
    console.log('Query param:', this.category, 'source:', source);

    if (this.category) {
      if (source === 'category') {
        this.store.dispatch(ResultActions.loadCategoryResults({ category: this.category }));
      } else {
        this.store.dispatch(ResultActions.loadSearchResults({ query: this.category }));
      }
      this.results$ = this.store.select(selectSearchResults);
    }
  }
}
