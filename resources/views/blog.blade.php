@extends('layouts.user')

@section('title','Bài viết')
@section('css')

<link href="{{ asset('css/blog.css') }}" rel="stylesheet">

@endsection
@section('content')
<main class="bg_gray">
		<div class="container margin_30">
			<div class="page_header">
				<div class="breadcrumbs">
					<ul>
						<li><a href="#">Home</a></li>
						<li><a href="#">Category</a></li>
						<li>Page active</li>
					</ul>
				</div>
				<h1>Allaia Blog &amp; News</h1>
			</div>
			<!-- /page_header -->
			<div class="row">
				<div class="col-lg-9">
					<div class="widget search_blog d-block d-sm-block d-md-block d-lg-none">
						<div class="form-group">
							<input type="text" name="search" id="search" class="form-control" placeholder="Search..">
							<button type="submit"><i class="ti-search"></i><span class="sr-only">Search</span></button>
						</div>
					</div>
					<!-- /widget -->
					<div class="row">
						<div class="col-md-6">
							<article class="blog">
								<figure>
									<a href="blog-post.html"><img src="img/blog-1.jpg" alt="">
										<div class="preview"><span>Read more</span></div>
									</a>
								</figure>
								<div class="post_info">
									<small>Category - 20 Nov. 2017</small>
									<h2><a href="blog-post.html">Ea exerci option hendrerit</a></h2>
									<p>Quodsi sanctus pro eu, ne audire scripserit quo. Vel an enim offendit salutandi, in eos quod omnes epicurei, ex veri qualisque scriptorem mei.</p>
									<ul>
										<li>
											<div class="thumb"><img src="img/avatar.jpg" alt=""></div> Admin
										</li>
										<li><i class="ti-comment"></i>20</li>
									</ul>
								</div>
							</article>
							<!-- /article -->
						</div>
						<!-- /col -->
						<div class="col-md-6">
							<article class="blog">
								<figure>
									<a href="blog-post.html"><img src="img/blog-2.jpg" alt="">
										<div class="preview"><span>Read more</span></div>
									</a>
								</figure>
								<div class="post_info">
									<small>Category - 20 Nov. 2017</small>
									<h2><a href="blog-post.html">At usu sale dolorum offendit</a></h2>
									<p>Quodsi sanctus pro eu, ne audire scripserit quo. Vel an enim offendit salutandi, in eos quod omnes epicurei, ex veri qualisque scriptorem mei.</p>
									<ul>
										<li>
											<div class="thumb"><img src="img/avatar.jpg" alt=""></div> Admin
										</li>
										<li><i class="ti-comment"></i>20</li>
									</ul>
								</div>
							</article>
							<!-- /article -->
						</div>
						<!-- /col -->
						<div class="col-md-6">
							<article class="blog">
								<figure>
									<a href="blog-post.html"><img src="img/blog-3.jpg" alt="">
										<div class="preview"><span>Read more</span></div>
									</a>
								</figure>
								<div class="post_info">
									<small>Category - 20 Nov. 2017</small>
									<h2><a href="blog-post.html">Iusto nominavi petentium in</a></h2>
									<p>Quodsi sanctus pro eu, ne audire scripserit quo. Vel an enim offendit salutandi, in eos quod omnes epicurei, ex veri qualisque scriptorem mei.</p>
									<ul>
										<li>
											<div class="thumb"><img src="img/avatar.jpg" alt=""></div> Admin
										</li>
										<li><i class="ti-comment"></i>20</li>
									</ul>
								</div>
							</article>
							<!-- /article -->
						</div>
						<!-- /col -->
						<div class="col-md-6">
							<article class="blog">
								<figure>
									<a href="blog-post.html"><img src="img/blog-4.jpg" alt="">
										<div class="preview"><span>Read more</span></div>
									</a>
								</figure>
								<div class="post_info">
									<small>Category - 20 Nov. 2017</small>
									<h2><a href="blog-post.html">Assueverit concludaturque quo</a></h2>
									<p>Quodsi sanctus pro eu, ne audire scripserit quo. Vel an enim offendit salutandi, in eos quod omnes epicurei, ex veri qualisque scriptorem mei.</p>
									<ul>
										<li>
											<div class="thumb"><img src="img/avatar.jpg" alt=""></div> Admin
										</li>
										<li><i class="ti-comment"></i>20</li>
									</ul>
								</div>
							</article>
							<!-- /article -->
						</div>
						<!-- /col -->
						<div class="col-md-6">
							<article class="blog">
								<figure>
									<a href="blog-post.html"><img src="img/blog-5.jpg" alt="">
										<div class="preview"><span>Read more</span></div>
									</a>
								</figure>
								<div class="post_info">
									<small>Category - 20 Nov. 2017</small>
									<h2><a href="blog-post.html">Nec nihil menandri appellantur</a></h2>
									<p>Quodsi sanctus pro eu, ne audire scripserit quo. Vel an enim offendit salutandi, in eos quod omnes epicurei, ex veri qualisque scriptorem mei.</p>
									<ul>
										<li>
											<div class="thumb"><img src="img/avatar.jpg" alt=""></div> Admin
										</li>
										<li><i class="ti-comment"></i>20</li>
									</ul>
								</div>
							</article>
							<!-- /article -->
						</div>
						<!-- /col -->
						<div class="col-md-6">
							<article class="blog">
								<figure>
									<a href="blog-post.html"><img src="img/blog-6.jpg" alt="">
										<div class="preview"><span>Read more</span></div>
									</a>
								</figure>
								<div class="post_info">
									<small>Category - 20 Nov. 2017</small>
									<h2><a href="blog-post.html">Te congue everti his salutandi</a></h2>
									<p>Quodsi sanctus pro eu, ne audire scripserit quo. Vel an enim offendit salutandi, in eos quod omnes epicurei, ex veri qualisque scriptorem mei.</p>
									<ul>
										<li>
											<div class="thumb"><img src="img/avatar.jpg" alt=""></div> Admin
										</li>
										<li><i class="ti-comment"></i>20</li>
									</ul>
								</div>
							</article>
							<!-- /article -->
						</div>
						<!-- /col -->
					</div>
					<!-- /row -->

					<div class="pagination__wrapper no_border add_bottom_30">
						<ul class="pagination">
							<li><a href="#0" class="prev" title="previous page">&#10094;</a></li>
							<li>
								<a href="#0" class="active">1</a>
							</li>
							<li>
								<a href="#0">2</a>
							</li>
							<li>
								<a href="#0">3</a>
							</li>
							<li>
								<a href="#0">4</a>
							</li>
							<li><a href="#0" class="next" title="next page">&#10095;</a></li>
						</ul>
					</div>
					<!-- /pagination -->

				</div>
				<!-- /col -->

				<aside class="col-lg-3">
					<div class="widget search_blog d-none d-sm-none d-md-none d-lg-block">
						<div class="form-group">
							<input type="text" name="search" id="search_blog" class="form-control" placeholder="Search..">
							<button type="submit"><i class="ti-search"></i><span class="sr-only">Search</span></button>
						</div>
					</div>
					<!-- /widget -->
					<div class="widget">
						<div class="widget-title">
							<h4>Latest Post</h4>
						</div>
						<ul class="comments-list">
							<li>
								<div class="alignleft">
									<a href="#0"><img src="img/blog-5.jpg" alt=""></a>
								</div>
								<small>Category - 11.08.2016</small>
								<h3><a href="#" title="">Verear qualisque ex minimum...</a></h3>
							</li>
							<li>
								<div class="alignleft">
									<a href="#0"><img src="img/blog-6.jpg" alt=""></a>
								</div>
								<small>Category - 11.08.2016</small>
								<h3><a href="#" title="">Verear qualisque ex minimum...</a></h3>
							</li>
							<li>
								<div class="alignleft">
									<a href="#0"><img src="img/blog-4.jpg" alt=""></a>
								</div>
								<small>Category - 11.08.2016</small>
								<h3><a href="#" title="">Verear qualisque ex minimum...</a></h3>
							</li>
						</ul>
					</div>
					<!-- /widget -->
					<div class="widget">
						<div class="widget-title">
							<h4>Categories</h4>
						</div>
						<ul class="cats">
							<li><a href="#">Food <span>(12)</span></a></li>
							<li><a href="#">Places to visit <span>(21)</span></a></li>
							<li><a href="#">New Places <span>(44)</span></a></li>
							<li><a href="#">Suggestions and guides <span>(31)</span></a></li>
						</ul>
					</div>
					<!-- /widget -->
					<div class="widget">
						<div class="widget-title">
							<h4>Popular Tags</h4>
						</div>
						<div class="tags">
							<a href="#">Food</a>
							<a href="#">Bars</a>
							<a href="#">Cooktails</a>
							<a href="#">Shops</a>
							<a href="#">Best Offers</a>
							<a href="#">Transports</a>
							<a href="#">Restaurants</a>
						</div>
					</div>
					<!-- /widget -->
				</aside>
				<!-- /aside -->
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</main>
@endsection