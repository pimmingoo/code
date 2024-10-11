import pygame
import random

# Initialize Pygame
pygame.init()

# Define colors
WHITE = (255, 255, 255)
BLACK = (0, 0, 0)

# Screen dimensions
SCREEN_WIDTH = 800
SCREEN_HEIGHT = 600

# Paddle dimensions
PADDLE_WIDTH = 10
PADDLE_HEIGHT = 100

# Ball dimensions
BALL_SIZE = 10

# Set up the display
screen = pygame.display.set_mode((SCREEN_WIDTH, SCREEN_HEIGHT))
pygame.display.set_caption("Pong Game")

# Game objects
class Paddle:
    def __init__(self, x, y):
        self.rect = pygame.Rect(x, y, PADDLE_WIDTH, PADDLE_HEIGHT)
        self.speed = 6

    def move(self, up=True):
        if up:
            self.rect.y -= self.speed
        else:
            self.rect.y += self.speed

    def keep_in_bounds(self):
        if self.rect.top < 0:
            self.rect.top = 0
        if self.rect.bottom > SCREEN_HEIGHT:
            self.rect.bottom = SCREEN_HEIGHT

class Ball:
    def __init__(self):
        self.rect = pygame.Rect(SCREEN_WIDTH // 2 - BALL_SIZE // 2, SCREEN_HEIGHT // 2 - BALL_SIZE // 2, BALL_SIZE, BALL_SIZE)
        self.speed_x = random.choice([-4, 4])
        self.speed_y = random.choice([-4, 4])

    def move(self):
        self.rect.x += self.speed_x
        self.rect.y += self.speed_y

    def bounce(self):
        if self.rect.top <= 0 or self.rect.bottom >= SCREEN_HEIGHT:
            self.speed_y *= -1

    def reset(self):
        self.__init__()

# Initialize paddles and ball
player1 = Paddle(30, SCREEN_HEIGHT // 2 - PADDLE_HEIGHT // 2)
player2 = Paddle(SCREEN_WIDTH - 30 - PADDLE_WIDTH, SCREEN_HEIGHT // 2 - PADDLE_HEIGHT // 2)
ball = Ball()

# Main game loop
running = True
clock = pygame.time.Clock()

# Player scores
player1_score = 0
player2_score = 0

while running:
    # Handle events
    for event in pygame.event.get():
        if event.type == pygame.QUIT:
            running = False

    # Player controls
    keys = pygame.key.get_pressed()
    
    if keys[pygame.K_w]:
        player1.move(up=True)
    if keys[pygame.K_s]:
        player1.move(up=False)
    if keys[pygame.K_UP]:
        player2.move(up=True)
    if keys[pygame.K_DOWN]:
        player2.move(up=False)

    # Move paddles and ball
    player1.keep_in_bounds()
    player2.keep_in_bounds()
    ball.move()
    ball.bounce()

    # Check for collisions with paddles
    if ball.rect.colliderect(player1.rect) or ball.rect.colliderect(player2.rect):
        ball.speed_x *= -1

    # Check for scoring
    if ball.rect.left <= 0:
        player2_score += 1
        ball.reset()
    elif ball.rect.right >= SCREEN_WIDTH:
        player1_score += 1
        ball.reset()

    # Drawing
    screen.fill(BLACK)
    pygame.draw.rect(screen, WHITE, player1.rect)
    pygame.draw.rect(screen, WHITE, player2.rect)
    pygame.draw.ellipse(screen, WHITE, ball.rect)
    pygame.draw.aaline(screen, WHITE, (SCREEN_WIDTH // 2, 0), (SCREEN_WIDTH // 2, SCREEN_HEIGHT))

    # Render the scores
    font = pygame.font.Font(None, 36)
    text = font.render(f"{player1_score}    {player2_score}", True, WHITE)
    screen.blit(text, (SCREEN_WIDTH // 2 - 50, 20))

    # Update the display
    pygame.display.flip()
    
    # Cap the frame rate
    clock.tick(60)

# Quit the game
if player1_score == 6:
    print("Player 1 wins!")
    pygame.quit()
elif player2_score == 6:
    print("Player 2 wins!")
    pygame.quit()