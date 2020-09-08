# there are many magic functions, but if not coding a common library, many of them are seldom used

import collections

Card = collections.namedtuple('Card', ['rank', 'suit']) 

class FrenchDeck: 
	ranks = [str(n) for n in range(2, 11)] + list('JQKA') 
	suits = 'spades diamonds clubs hearts'.split() 
	
	def __init__(self): self._cards = [Card(rank, suit) for suit in self.suits for rank in self.ranks] 
	
	# when the class object is used as a string
	def __repr__(self):
		return "hehe"

	# when len(object) is called
	def __len__(self): return len(self._cards) 

	# use the object as a array
	def __getitem__(self, position): return self._cards[position]

	def __call__(self, param):
		print("this function is not exist, your param is %s" % param)

deck = FrenchDeck()
print(len(deck))

beer_card = Card('7', 'diamonds')

print(deck[0])

# cannot call __call() function, not like php
# deck.test("test")

print(deck)
