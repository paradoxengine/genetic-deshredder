The aim of this tool is to be able to rebuild pages from shredded stripes.

The approach that this code takes is very simple: instead of trying to analyze the images, it randomly rebuilds the stripes, generates a document and send it to an OKR. The resulting text is then passed to a spell checker: hopefully, the "right" ordering of stripes will result in less errors than the "wrong" ordering, and a partial ordering will have less errors than a random configuration.

This approach can be combined with a first layer coarse analysis of the stripes to quickly reach a local optimum.

I'm not sure anymore of the shape of the code, but in the last iterations I managed to rebuild fairly complex documents.

This code uses a custom built Genetic Algorithm library for PHP, GENELIB, which can also be useful in other projects.


NOTE: this code is nowhere near release-quality, but it has been sitting in my hard drive for so long that I don't see any point keeping it buried there.